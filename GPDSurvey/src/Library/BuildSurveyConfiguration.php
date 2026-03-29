<?php

namespace GPDSurvey\Library;

use GPDCore\Doctrine\EntityHydrator;
use GPDCore\Contracts\AppContextInterface;
use GPDSurvey\Entities\SurveyConfiguration;

class BuildSurveyConfiguration
{

    public static function build(AppContextInterface $context, ?array $input): ?SurveyConfiguration
    {
        if (empty($input) || !is_array($input)) {
            return null;
        }
        $entityManager = $context->getEntityManager();
        $configuration = new SurveyConfiguration();
        EntityHydrator::hydrate($entityManager, $configuration, $input);
        $entityManager->persist($configuration);
        $entityManager->flush();
        return $configuration;
    }
}
