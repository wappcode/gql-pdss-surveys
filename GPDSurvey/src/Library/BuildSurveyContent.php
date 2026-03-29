<?php

namespace GPDSurvey\Library;

use GPDCore\Contracts\AppContextInterface;
use GPDCore\Doctrine\EntityHydrator;
use GPDSurvey\Entities\SurveyContent;

class BuildSurveyContent
{

    public static function build(AppContextInterface $context, ?array $input): ?SurveyContent
    {
        if (empty($input) || !is_array($input)) {
            return null;
        }
        $entityManager = $context->getEntityManager();
        $content = new SurveyContent();
        $input["presentation"] = BuildSurveyConfiguration::build($context, $input["presentation"] ?? null);
        EntityHydrator::hydrate($entityManager, $content, $input);
        $entityManager->persist($content);
        $entityManager->flush();
        return $content;
    }
}
