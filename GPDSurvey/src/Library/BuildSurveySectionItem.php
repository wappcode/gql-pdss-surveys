<?php

namespace GPDSurvey\Library;

use GPDCore\Graphql\ArrayToEntity;
use GPDCore\Library\IContextService;
use GPDSurvey\Entities\SurveySectionItem;

class BuildSurveySectionItem
{

    public static function build(IContextService $context, ?array $input): ?SurveySectionItem
    {
        if (empty($input) || !is_array($input)) {
            return null;
        }
        $entityManager = $context->getEntityManager();
        $input["content"] = BuildSurveyContent::build($context, $input["content"] ?? null);
        $questionInput = $input["question"] ?? null;
        if (!empty($questionInput)) {
            $questionInput["survey"] = $input["section"]->getSurvey();
        }
        $input["question"] = BuildSurveyQuestion::build($context, $questionInput);
        $input["presentation"] = BuildSurveyConfiguration::build($context, $input["presentation"] ?? null);
        $input["conditions"] = BuildSurveyConfiguration::build($context, $input["conditions"] ?? null);
        $targetAudience = new SurveySectionItem();
        ArrayToEntity::setValues($entityManager, $targetAudience, $input);
        $entityManager->persist($targetAudience);
        $entityManager->flush();
        return $targetAudience;
    }
}
