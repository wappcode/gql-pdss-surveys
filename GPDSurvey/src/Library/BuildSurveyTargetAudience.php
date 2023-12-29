<?php

namespace GPDSurvey\Library;

use Exception;
use GPDCore\Graphql\ArrayToEntity;
use GPDCore\Library\IContextService;
use GPDSurvey\Entities\Survey;
use GPDSurvey\Entities\SurveyTargetAudience;

class BuildSurveyTargetAudience
{

    public static function build(IContextService $context, ?array $input): ?SurveyTargetAudience
    {
        if (empty($input) || !is_array($input)) {
            return null;
        }
        $entityManager = $context->getEntityManager();
        $input["welcome"] = BuildSurveyContent::build($context, $input["welcome"] ?? null);
        $input["farewell"] = BuildSurveyContent::build($context, $input["farewell"] ?? null);
        $targetAudience = new SurveyTargetAudience();
        ArrayToEntity::setValues($entityManager, $targetAudience, $input);
        $entityManager->persist($targetAudience);
        $entityManager->flush();
        return $targetAudience;
    }
}
