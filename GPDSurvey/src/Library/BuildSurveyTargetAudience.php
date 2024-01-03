<?php

namespace GPDSurvey\Library;

use Exception;
use GPDCore\Graphql\ArrayToEntity;
use GPDCore\Library\GQLException;
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

        if (empty($input["survey"])) {
            throw new GQLException("Survey is required");
        }
        if (is_string($input["survey"])) {
            $input["survey"] = $entityManager->find(Survey::class, $input["survey"]);
        }
        $targetAudience = new SurveyTargetAudience();
        ArrayToEntity::setValues($entityManager, $targetAudience, $input);
        $entityManager->persist($targetAudience);
        $entityManager->flush();
        return $targetAudience;
    }
}
