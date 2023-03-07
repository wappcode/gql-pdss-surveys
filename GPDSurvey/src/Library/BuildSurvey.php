<?php

namespace GPDSurvey\Library;

use Exception;
use GPDCore\Graphql\ArrayToEntity;
use GPDCore\Library\IContextService;
use GPDSurvey\Entities\Survey;
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
            "title" => $input["title"]
        ];
        $survey = new Survey();
        ArrayToEntity::apply($survey, $surveyInput);
        $entityManager->persist($survey);
        $entityManager->flush();
        $targetAudienceInput = $input["targetAudience"] ?? null;
        if (is_array($targetAudienceInput) && !empty($targetAudienceInput)) {
            $targetAudienceInput["survey"] = $survey;
        }
        $targetAudience = BuildSurveyTargetAudience::build($context, $targetAudienceInput);
        $sectionsInput = $input["sections"] ?? [];
        $sections = static::buildSections($context, $sectionsInput, $survey);


        return $survey;
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
}
