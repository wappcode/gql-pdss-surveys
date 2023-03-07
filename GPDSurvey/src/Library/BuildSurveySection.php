<?php

namespace GPDSurvey\Library;

use GPDCore\Graphql\ArrayToEntity;
use GPDCore\Library\IContextService;
use GPDSurvey\Entities\SurveySection;

class BuildSurveySection
{

    public static function build(IContextService $context, ?array $input): ?SurveySection
    {
        if (empty($input) || !is_array($input)) {
            return null;
        }
        $entityManager = $context->getEntityManager();
        $input["content"] = BuildSurveyContent::build($context, $input["content"] ?? null);
        $input["presentation"] = BuildSurveyConfiguration::build($context, $input["presentation"] ?? null);
        $section = new SurveySection();

        $sectionInput = $input;
        unset($sectionInput["items"]);

        ArrayToEntity::apply($section, $sectionInput);
        $entityManager->persist($section);
        $entityManager->flush();
        $itemsInput = $input["items"] ?? [];
        $items = static::buildItems($context, $itemsInput, $section);
        return $section;
    }
    public static function buildItems(IContextService $context, array $itemsInput, SurveySection $section): array
    {
        $items = array_map(function ($input) use ($context, $section) {
            $input["section"] = $section;
            $item = BuildSurveySectionItem::build($context, $input);
            return $item;
        }, $itemsInput);
        return $items;
    }
}
