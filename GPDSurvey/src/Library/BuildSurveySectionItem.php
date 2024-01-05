<?php

namespace GPDSurvey\Library;

use Exception;
use GPDCore\Graphql\ArrayToEntity;
use GPDCore\Library\GQLException;
use GPDCore\Library\IContextService;
use GPDSurvey\Entities\SurveyConfiguration;
use GPDSurvey\Entities\SurveyContent;
use GPDSurvey\Entities\SurveyQuestion;
use GPDSurvey\Entities\SurveySection;
use GPDSurvey\Entities\SurveySectionItem;

class BuildSurveySectionItem
{

    public static function build(IContextService $context, ?array $input): ?SurveySectionItem
    {
        if (empty($input) || !is_array($input)) {
            return null;
        }
        $entityManager = $context->getEntityManager();

        if (is_string($input["section"]) && !empty($input["section"])) {
            $input["section"] = $entityManager->find(SurveySection::class, $input["section"]);
        }
        if (!($input["section"] instanceof SurveySection)) {
            throw new GQLException("Survey section is required");
        }
        if (!empty($questionInput)) {
            $questionInput["survey"] = $input["section"]->getSurvey();
        }

        $id = $input["id"] ?? null;
        $surveySectionItem = new SurveySectionItem();
        if (!empty($id)) {
            $surveySectionItem = static::getSurveySectionItem($context, $id);
            if (!($surveySectionItem instanceof SurveySectionItem)) {
                throw new GQLException("Invalid Survey Section Item ID");
            }
        }
        $entityManager->beginTransaction();
        try {
            static::removeContentAndConditions($context, $surveySectionItem);
            $input["content"] = BuildSurveyContent::build($context, $input["content"] ?? null);
            $questionInput = $input["question"] ?? null;
            static::removeObsoleteQuestion($context, $surveySectionItem, $questionInput["id"] ?? null);
            if (!empty($questionInput) && $input["section"] instanceof SurveySection) {
                $questionInput["survey"] = $input["section"]->getSurvey();
            }
            $input["question"] = BuildSurveyQuestion::build($context, $questionInput);
            $input["conditions"] = BuildSurveyConfiguration::build($context, $input["conditions"] ?? null);
            ArrayToEntity::setValues($entityManager, $surveySectionItem, $input);
            $entityManager->persist($surveySectionItem);
            $entityManager->flush();
            $entityManager->commit();
            return $surveySectionItem;
        } catch (Exception $e) {
            $entityManager->rollback();
            throw $e;
        }
    }


    private static function getSurveySectionItem(IContextService $context, $id): ?SurveySectionItem
    {
        $entityManager = $context->getEntityManager();
        $qb = $entityManager->createQueryBuilder()->from(SurveySectionItem::class, 'item')
            ->leftJoin('item.question', 'question')
            ->leftJoin('item.content', 'content')
            ->leftJoin('item.conditions', 'conditions')
            ->select(["item", "partial question.{id}", "partial content.{id}", "partial conditions.{conditions}"]);
        $item = $qb->andWhere("item.id = :id")->setParameter(":id", $id)->getQuery()->getOneOrNullResult();
        return $item;
    }

    private static function removeContentAndConditions(IContextService $context, SurveySectionItem $item)
    {

        $content = $item->getContent();
        $conditions = $item->getConditions();
        $entityManager = $context->getEntityManager();
        $item->setContent(null);
        $item->setConditions(null);
        $entityManager->flush();

        if ($content instanceof SurveyContent) {
            DeleteSurveyContent::delete($context, $content->getId());
        }
        if ($conditions instanceof SurveyConfiguration) {
            DeleteSurveyConfiguration::delete($context, $conditions->getId());
        }
    }

    private static function removeObsoleteQuestion(IContextService $context, SurveySectionItem $item, ?string $questionId)
    {
        $question = $item->getQuestion();
        if (!($question instanceof SurveyQuestion)) {
            return;
        }
        if (empty($questionId)) {
            DeleteSurveyQuestion::delete($context, $question->getId());
        }
    }
}
