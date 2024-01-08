<?php

namespace GPDSurvey\Library;

use Exception;
use GPDCore\Library\GQLException;
use GPDCore\Graphql\ArrayToEntity;
use GPDCore\Library\IContextService;
use GPDSurvey\Entities\SurveyContent;
use GPDSurvey\Entities\SurveyQuestion;
use GPDSurvey\Entities\SurveyConfiguration;
use GPDSurvey\Entities\SurveyQuestionOption;

class BuildSurveyQuestionOption
{

    public static function build(IContextService $context, ?array $input): ?SurveyQuestionOption
    {
        if (empty($input) || !is_array($input)) {
            return null;
        }
        $entityManager = $context->getEntityManager();
        if (is_string($input["question"])) {
            $input["question"] = $entityManager->find(SurveyQuestion::class, $input["question"]);
        }
        if (!($input["question"] instanceof SurveyQuestion)) {
            throw new GQLException("Survey Question is required");
        }
        $id = $input["id"] ?? null;
        $option = new SurveyQuestionOption();
        if (!empty($id)) {
            $option = static::getOption($context, $id);
            if (!($option instanceof SurveyQuestionOption)) {
                throw new GQLException("Invalid Question Option ID");
            }
        }
        $entityManager->beginTransaction();
        try {
            static::removeContentPresentation($context, $option);
            $input["content"] = BuildSurveyContent::build($context, $input["content"] ?? null);
            $input["presentation"] = BuildSurveyConfiguration::build($context, $input["presentation"] ?? null);
            ArrayToEntity::setValues($entityManager, $option, $input);
            $entityManager->persist($option);
            $entityManager->flush();
            $entityManager->commit();
            return $option;
        } catch (Exception $e) {
            $entityManager->rollback();
            throw $e;
        }
    }


    private static function getOption(IContextService $contxt, $id): ?SurveyQuestionOption
    {
        $entityManager = $contxt->getEntityManager();
        $qb = $entityManager->createQueryBuilder()->from(SurveyQuestionOption::class, 'option')
            ->leftJoin("option.content", "content")
            ->leftJoin("option.presentation", "presentation")
            ->select(["option", "partial presentation.{id}", "partial content.{id}"]);
        $option = $qb->andWhere("option.id = :id", $id)->getQuery()->getOneOrNullResult();
        return $option;
    }

    private static function removeContentPresentation(IContextService $context, SurveyQuestionOption $option)
    {
        $entityManager = $context->getEntityManager();
        $content = $option->getContent();
        $presentation = $option->getPresentation();
        $option->setPresentation(null)->setPresentation(null);
        $entityManager->flush();
        if ($content instanceof SurveyContent) {
            DeleteSurveyContent::delete($context, $content->getId());
        }
        if ($presentation instanceof SurveyConfiguration) {
            DeleteSurveyConfiguration::delete($context, $presentation->getId());
        }
    }
}
