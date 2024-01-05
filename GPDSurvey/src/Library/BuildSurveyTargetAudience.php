<?php

namespace GPDSurvey\Library;

use Exception;
use GPDCore\Graphql\ArrayToEntity;
use GPDCore\Library\GQLException;
use GPDCore\Library\IContextService;
use GPDSurvey\Entities\Survey;
use GPDSurvey\Entities\SurveyConfiguration;
use GPDSurvey\Entities\SurveyContent;
use GPDSurvey\Entities\SurveyTargetAudience;

class BuildSurveyTargetAudience
{

    public static function build(IContextService $context, ?array $input): ?SurveyTargetAudience
    {
        if (empty($input) || !is_array($input)) {
            return null;
        }
        $id = $input["id"] ?? null;
        $entityManager = $context->getEntityManager();
        $input["welcome"] = BuildSurveyContent::build($context, $input["welcome"] ?? null);
        $input["farewell"] = BuildSurveyContent::build($context, $input["farewell"] ?? null);
        $input["presentation"] = BuildSurveyConfiguration::build($context, $input["presentation"] ?? null);

        if (empty($input["survey"])) {
            throw new GQLException("Survey is required");
        }
        if (is_string($input["survey"])) {
            $input["survey"] = $entityManager->find(Survey::class, $input["survey"]);
        }
        $entityManager->beginTransaction();
        try {
            $targetAudience = new SurveyTargetAudience();
            if (!empty($id)) {
                $targetAudience = static::getAudience($context, $id);
                static::clearRelations($context, $targetAudience);
            }
            ArrayToEntity::setValues($entityManager, $targetAudience, $input);
            $entityManager->persist($targetAudience);
            $entityManager->flush();
            $entityManager->commit();
            return $targetAudience;
        } catch (Exception $e) {
            $entityManager->rollback();
            throw $e;
        }
    }

    private static function getAudience(IContextService $context, $id)
    {
        $entityManager = $context->getEntityManager();
        $qb = $entityManager->createQueryBuilder()->from(SurveyTargetAudience::class, 'audience')
            ->leftJoin("audience.welcome", "welcome")
            ->leftJoin("audience.farewell", "farewell")
            ->leftJoin("audience.presentation", "presentation")
            ->select(["audience", "partial welcome.{id}", "partial farewell.{id}", "partial presentation.{id}"]);
        $survey = $qb->andWhere("audience.id = :id")
            ->setParameter(":id", $id)
            ->getQuery()->getOneOrNullResult();
        return $survey;
    }

    /**
     * Elimina las relaciones de contenido y presentación  antes de insertar el nuevo
     *
     * @param SurveyTargetAudience $audience
     * @return void
     */
    private static function clearRelations(IContextService $context, SurveyTargetAudience $audience)
    {
        $entityManager = $context->getEntityManager();
        $welcome = $audience->getWelcome();
        $farewell = $audience->getFarewell();
        $presentation = $audience->getPresentation();
        $audience->setWelcome(null);
        $audience->setFarewell(null);
        $audience->setPresentation(null);
        $entityManager->flush();
        if ($welcome instanceof SurveyContent) {
            DeleteSurveyContent::delete($context, $welcome->getId());
        }
        if ($farewell instanceof SurveyContent) {
            DeleteSurveyContent::delete($context, $farewell->getId());
        }
        if ($presentation instanceof SurveyConfiguration) {
            DeleteSurveyConfiguration::delete($context, $presentation->getId());
        }
    }
}
