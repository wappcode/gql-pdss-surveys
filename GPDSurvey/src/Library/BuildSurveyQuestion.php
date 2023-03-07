<?php

namespace GPDSurvey\Library;

use GPDCore\Graphql\ArrayToEntity;
use GPDCore\Library\IContextService;
use GPDSurvey\Entities\SurveyQuestion;
use GPDSurvey\Entities\SurveySectionItem;
use GPDSurvey\Entities\SurveyTargetAudience;

class BuildSurveyQuestion
{

    public static function build(IContextService $context, ?array $input): ?SurveyQuestion
    {
        if (empty($input) || !is_array($input)) {
            return null;
        }
        $entityManager = $context->getEntityManager();
        $input["content"] = BuildSurveyContent::build($context, $input["content"] ?? null);
        $input["presentation"] = BuildSurveyConfiguration::build($context, $input["presentation"] ?? null);
        $inputQuestion = $input;
        unset($inputQuestion["options"]);
        $question = new SurveyQuestion();
        ArrayToEntity::apply($question, $inputQuestion);
        $entityManager->persist($question);
        $entityManager->flush();
        $optionsInput = $input["options"] ?? [];
        $options = static::buildOptions($context, $optionsInput, $question);
        return $question;
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
}
