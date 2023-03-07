<?php

namespace GPDSurvey\Library;

use GPDCore\Graphql\ArrayToEntity;
use GPDCore\Library\IContextService;
use GPDSurvey\Entities\SurveySection;
use GPDSurvey\Entities\SurveySectionItem;
use GPDSurvey\Entities\SurveyTargetAudience;

class BuildSurveySectionItem
{

    public static function build(IContextService $context, ?array $input): ?SurveyTargetAudience
    {
        if (empty($input) || !is_array($input)) {
            return null;
        }
        $entityManager = $context->getEntityManager();
        $input["content"] = BuildSurveyContent::build($context, $input["content"]);
        $input["question"] = BuildSurveyConfiguration::build($context, $input["question"]);
        $input["presentation"] = BuildSurveyConfiguration::build($context, $input["presentation"]);
        $input["conditions"] = BuildSurveyConfiguration::build($context, $input["conditions"]);
        $targetAudience = new SurveySectionItem();
        ArrayToEntity::apply($targetAudience, $input);
        $entityManager->persist($targetAudience);

        return $targetAudience;
    }
}
