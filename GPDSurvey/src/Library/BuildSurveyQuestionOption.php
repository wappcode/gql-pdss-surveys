<?php

namespace GPDSurvey\Library;

use GPDCore\Graphql\ArrayToEntity;
use GPDCore\Library\IContextService;
use GPDSurvey\Entities\SurveyQuestionOption;
use GPDSurvey\Entities\SurveyTargetAudience;

class BuildSurveyQuestionOption
{

    public static function build(IContextService $context, ?array $input): ?SurveyQuestionOption
    {
        if (empty($input) || !is_array($input)) {
            return null;
        }
        $entityManager = $context->getEntityManager();
        $input["content"] = BuildSurveyContent::build($context, $input["content"]);
        $input["presentation"] = BuildSurveyConfiguration::build($context, $input["presentation"]);
        $option = new SurveyQuestionOption();
        ArrayToEntity::apply($option, $input);
        $entityManager->persist($option);

        return $option;
    }
}
