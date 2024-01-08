<?php

namespace GPDSurvey\Library;

use Exception;
use GPDSurvey\Entities\Survey;
use GPDCore\Library\GQLException;
use GPDCore\Graphql\ArrayToEntity;
use GPDCore\Library\IContextService;
use GPDSurvey\Entities\SurveyContent;
use GPDSurvey\Entities\SurveyQuestion;
use GPDSurvey\Entities\SurveyConfiguration;
use GPDSurvey\Entities\SurveyQuestionOption;

class BuildSurveyQuestion
{

    public static function build(IContextService $context, ?array $input): ?SurveyQuestion
    {
        if (empty($input) || !is_array($input)) {
            return null;
        }
        $entityManager = $context->getEntityManager();
        if (is_string($input["survey"]) && !empty($input["survey"])) {
            $input["survey"] = $entityManager->find(Survey::class, $input["survey"]);
        }
        if (!($input["survey"] instanceof Survey)) {
            throw new GQLException("Survey is required");
        }
        $id = $input["id"];
        $question = new SurveyQuestion();
        if (!empty($id)) {
            $question = static::getSurveyQuestion($context, $id);
            if (!($question instanceof SurveyQuestion)) {
                throw new GQLException("Invalid Question ID");
            }
        }
        $entityManager->beginTransaction();
        try {
            static::removeContentPresentationScoresAndValidators($context, $question);
            $input["content"] = BuildSurveyContent::build($context, $input["content"] ?? null);
            $input["presentation"] = BuildSurveyConfiguration::build($context, $input["presentation"] ?? null);
            $input["validators"] = BuildSurveyConfiguration::build($context, $input["validators"] ?? null);
            $input["answerScore"] = BuildSurveyConfiguration::build($context, $input["answerScore"] ?? null);
            $inputQuestion = $input;
            unset($inputQuestion["options"]);
            ArrayToEntity::setValues($entityManager, $question, $inputQuestion);
            $entityManager->persist($question);
            $entityManager->flush();
            $optionsInput = $input["options"] ?? [];
            $currentOptionsIds = static::getCurrentOptionsIds($question);
            $inputOptionsIds = static::getInputOptionsIds($optionsInput);
            $optionsIdsToRemove = array_diff($currentOptionsIds, $inputOptionsIds);
            static::removeObsoleteOptions($context, $optionsIdsToRemove);
            $options = static::buildOptions($context, $optionsInput, $question);
            $entityManager->commit();
            return $question;
        } catch (Exception $e) {
            $entityManager->rollback();
            throw $e;
        }
    }

    protected static function buildOptions(IContextService $context, array $optionsInput, SurveyQuestion $question): array
    {
        $options = array_map(function ($input) use ($context, $question) {
            $input["question"] = $question;
            $option = BuildSurveyQuestionOption::build($context, $input);
            return $option;
        }, $optionsInput);
        return $options;
    }

    private static function getSurveyQuestion(IContextService $context, $id): ?SurveyQuestion
    {
        $entityManager = $context->getEntityManager();
        $qb = $entityManager->createQueryBuilder()->from(SurveyQuestion::class, "question")
            ->leftJoin("question.content", "content")
            ->leftJoin("question.presentation", "presentation")
            ->leftJoin("question.answerScore", "answerScore")
            ->leftJoin("question.validators", "validators")
            ->leftJoin("question.options", "options")
            ->select(["question", "partial content.{id}", "partial presentation.{id}", "partial answerScore.{id}", "partial validators.{id}", "partial options.{id}"]);
        $question = $qb->andWhere("question.id = :id")->setParameter(":id", $id)->getQuery()->getOneOrNullResult();
        return $question;
    }

    private static function removeContentPresentationScoresAndValidators(IContextService $context, SurveyQuestion $question)
    {

        $content = $question->getContent();
        $validators = $question->getValidators();
        $presentation = $question->getPresentation();
        $answerScore = $question->getAnswerScore();

        $question->setValidators(null)->setAnswerScore(null)->setPresentation(null)->setContent(null);
        $entityManager = $context->getEntityManager();
        $entityManager->flush();

        if ($content instanceof SurveyContent) {
            DeleteSurveyContent::delete($context, $content->getId());
        }
        if ($validators instanceof SurveyConfiguration) {
            DeleteSurveyConfiguration::delete($context, $validators->getId());
        }
        if ($presentation instanceof SurveyConfiguration) {
            DeleteSurveyConfiguration::delete($context, $presentation->getId());
        }
        if ($answerScore instanceof SurveyConfiguration) {
            DeleteSurveyConfiguration::delete($context, $answerScore->getId());
        }
    }

    private static function getCurrentOptionsIds(SurveyQuestion $question): array
    {
        $ids = array_map(function (SurveyQuestionOption $option) {
            return $option->getId();
        }, $question->getOptions()->toArray());
        return $ids;
    }
    private static function getInputOptionsIds(array $optionsInput)
    {
        $ids = array_map(function ($option) {
            return $option["id"];
        }, $optionsInput);
        $ids = array_filter($ids, function ($id) {
            return !empty($id);
        });
        $ids = array_map("intval", $ids);
        return $ids;
    }

    private static function removeObsoleteOptions(IContextService $context, $optionsIds)
    {
        if (empty($optionsIds)) {
            return;
        }
        foreach ($optionsIds as $id) {
            DeleteSurveyQuestionOption::delete($context, $id);
        }
    }
}
