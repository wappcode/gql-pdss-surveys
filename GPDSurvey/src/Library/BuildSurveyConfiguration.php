<?php

namespace GPDSurvey\Library;

use GPDCore\Graphql\ArrayToEntity;
use GPDCore\Library\IContextService;
use GPDSurvey\Entities\SurveyConfiguration;

class BuildSurveyConfiguration
{

    public static function build(IContextService $context, ?array $input): ?SurveyConfiguration
    {
        if (empty($input) || !is_array($input)) {
            return null;
        }
        $entityManager = $context->getEntityManager();
        $configuration = new SurveyConfiguration();
        ArrayToEntity::apply($configuration, $input);
        $entityManager->persist($configuration);
        $entityManager->flush();
        return $configuration;
    }
}
