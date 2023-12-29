<?php

namespace GPDSurvey\Library;

use GPDCore\Graphql\ArrayToEntity;
use GPDCore\Library\IContextService;
use GPDSurvey\Entities\SurveyConfiguration;
use GPDSurvey\Entities\SurveyContent;

class BuildSurveyContent
{

    public static function build(IContextService $context, ?array $input): ?SurveyContent
    {
        if (empty($input) || !is_array($input)) {
            return null;
        }
        $entityManager = $context->getEntityManager();
        $content = new SurveyContent();
        $input["presentation"] = BuildSurveyConfiguration::build($context, $input["presentation"] ?? null);
        ArrayToEntity::setValues($entityManager, $content, $input);
        $entityManager->persist($content);
        $entityManager->flush();
        return $content;
    }
}
