<?php

namespace GPDSurvey\Library;

use Exception;
use GPDCore\Graphql\ArrayToEntity;
use GPDCore\Library\GQLException;
use GPDCore\Library\IContextService;
use GPDSurvey\Entities\Survey;
use GPDSurvey\Entities\SurveySection;
use GPDSurvey\Entities\SurveyTargetAudience;

class BuildSurvey
{

    public static function build(IContextService $context, ?array $input): ?Survey
    {
        if (empty($input) || !is_array($input)) {
            return null;
        }
        $entityManager = $context->getEntityManager();
        $surveyInput = [
            "title" => $input["title"],
            "active" => $input["active"]
        ];
        $id = $input["id"] ?? null;
        if (empty($input["sections"])) {
            throw new GQLException("Sections are required");
        }
        // Si se pasa el parámetro id se actualiza la encuesta en ves de crear una nueva
        $survey = empty($id) ? new Survey() : $entityManager->find(Survey::class, $id);
        if (!($survey instanceof Survey)) {
            throw new GQLException("Invalid survey ID");
        }
        $entityManager->beginTransaction();
        try {

            ArrayToEntity::setValues($entityManager, $survey, $surveyInput);
            if (empty($id)) {
                $entityManager->persist($survey);
            }
            $entityManager->flush();

            // No se quitan target audiences solo se actualizan o se crean nuevas
            $targetAudienceInput = $input["targetAudience"] ?? null;
            if (is_array($targetAudienceInput) && !empty($targetAudienceInput)) {
                $targetAudienceInput["survey"] = $survey;
            }
            $targetAudience = BuildSurveyTargetAudience::build($context, $targetAudienceInput);
            $sectionsInput = $input["sections"] ?? [];
            $currentSectionsIds = static::getCurrentSectionsIds($context, $id);
            $sectionsInputIds = static::getInputSectionIds($sectionsInput);
            $sectionsIdsToDelete = array_diff($currentSectionsIds, $sectionsInputIds);
            //TODO: Desarrollar la opción para actualizar secciones
            $sections = static::buildSections($context, $sectionsInput, $survey);
            // se eliminan las secciones que ya no son necesarias
            if (!empty($id)) {
                foreach ($sectionsIdsToDelete as $sectionId) {
                    DeleteSurveySection::delete($context, $sectionId);
                }
            }

            $entityManager->commit();
            return $survey;
        } catch (Exception $e) {
            $entityManager->rollback();
            throw $e;
        }
    }

    protected static function buildSections($context, array $sectionsInput, Survey $survey): array
    {
        $sections = array_map(function ($input) use ($context, $survey) {
            $input["survey"] = $survey;
            $section = BuildSurveySection::build($context, $input);
            return $section;
        }, $sectionsInput);
        return $sections;
    }

    private static function getCurrentSectionsIds(IContextService $context, ?string $surveyId)
    {
        if (empty($surveyId)) {
            return [];
        }
        $entityManager = $context->getEntityManager();
        $qb = $entityManager->createQueryBuilder()->from(SurveySection::class, 'section')
            ->select('section.id');
        $result = $qb->andWhere("section.survey = :surveyId")->setParameter(":surveyId", $surveyId)->getQuery()->getArrayResult();
        $ids = array_map("current", $result);
        return $ids;
    }

    private static function getInputSectionIds(array $sections)
    {

        $ids = array_map(function ($section) {
            return $section["id"] ?? null;
        }, $sections);
        $ids = array_filter($ids, function ($id) {
            return !empty($id);
        });
        return $ids;
    }
}
