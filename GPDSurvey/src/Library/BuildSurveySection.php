<?php

namespace GPDSurvey\Library;

use Exception;
use GPDSurvey\Entities\Survey;
use GPDCore\Library\GQLException;
use GPDCore\Graphql\ArrayToEntity;
use GPDCore\Library\IContextService;
use GPDSurvey\Entities\SurveyContent;
use GPDSurvey\Entities\SurveySection;
use GPDSurvey\Entities\SurveySectionItem;
use GPDSurvey\Entities\SurveyConfiguration;

class BuildSurveySection
{

    public static function build(IContextService $context, ?array $input): ?SurveySection
    {
        if (empty($input) || !is_array($input)) {
            return null;
        }
        $id = $input["id"] ?? null;
        $entityManager = $context->getEntityManager();
        $input["content"] = BuildSurveyContent::build($context, $input["content"] ?? null);
        $input["presentation"] = BuildSurveyConfiguration::build($context, $input["presentation"] ?? null);

        if (empty($input["items"])) {
            throw new GQLException("Section items are required");
        }
        $section = new SurveySection();
        $entityManager->beginTransaction();
        try {
            if (!empty($id)) {
                $section = static::getSection($context, $id);
                if (!($section instanceof SurveySection)) {
                    throw new GQLException("Invalid Survey Section ID");
                }
            }
            if (empty($input["survey"])) {
                throw new GQLException("Survey is required");
            }
            if (is_string($input["survey"])) {
                $input["survey"] = $entityManager->find(Survey::class, $input["survey"]);
            }
            $sectionInput = $input;
            unset($sectionInput["items"]);

            ArrayToEntity::setValues($entityManager, $section, $sectionInput);
            $entityManager->persist($section);
            $entityManager->flush();

            $currentItemsIds = static::getCurrentItemsIds($section);
            $inputItemsIds = static::getInputItemsIds($input["items"]);
            $itemsToDelete = array_diff($currentItemsIds, $inputItemsIds);
            static::removeNotUsedItems($context, $itemsToDelete);
            $itemsInput = $input["items"] ?? [];
            $items = static::buildItems($context, $itemsInput, $section);
            $entityManager->commit();
            return $section;
        } catch (Exception $e) {
            $entityManager->rollback();
            throw $e;
        }
    }
    public static function buildItems(IContextService $context, array $itemsInput, SurveySection $section): array
    {
        $items = array_map(function ($input) use ($context, $section) {
            $input["section"] = $section;
            $item = BuildSurveySectionItem::build($context, $input);
            return $item;
        }, $itemsInput);
        return $items;
    }

    public static function getSection(IContextService $context, string $id): ?SurveySection
    {
        $entityManager = $context->getEntityManager();
        $qb = $entityManager->createQueryBuilder()->from(SurveySection::class, 'section')
            ->leftJoin("section.items", "items")
            ->leftJoin("section.content", "content")
            ->leftJoin("section.presentation", "presentation")
            ->select(["section", "items", "partial content.{id}", "partial presentation.{id}"]);
        /** @var SurveySection */
        $section = $qb->andWhere("section.id = :id")->setParameter(":id", $id)->getQuery()->getOneOrNullResult();
        return $section;
    }

    public static function clearContentAndPresentation(IContextService $context, SurveySection $section)
    {
        $entityManager = $context->getEntityManager();
        $content = $section->getContent();
        $presentation = $section->getPresentation();
        $section->setPresentation(null);
        $section->setContent(null);
        $entityManager->flush();
        if ($content instanceof SurveyContent) {
            DeleteSurveyContent::delete($context, $content->getId());
        }
        if ($presentation instanceof SurveyConfiguration) {
            DeleteSurveyConfiguration::delete($context, $presentation->getId());
        }
    }

    public static function getCurrentItemsIds(SurveySection $section): array
    {
        $items = array_map(function (SurveySectionItem $item) {
            return $item->getId();
        }, $section->getItems()->toArray());
        return $items;
    }

    public static function getInputItemsIds(array $itemsInput): array
    {
        $ids = array_map(function ($item) {
            return $item["id"] ?? null;
        }, $itemsInput);
        $ids = array_filter($ids, function ($id) {
            return !empty($id);
        });
        return $ids;
    }

    public static function removeNotUsedItems(IContextService $context, array $ids)
    {
        if (empty($ids)) {
            return;
        }
        foreach ($ids as $id) {
            DeleteSurveySectionItem::delete($context, $id);
        }
    }
}
