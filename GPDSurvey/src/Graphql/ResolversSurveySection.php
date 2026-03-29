<?php

declare(strict_types=1);

namespace GPDSurvey\Graphql;

use GPDCore\DataLoaders\EntityDataLoader;
use GPDSurvey\Entities\SurveyContent;
use GPDSurvey\Entities\SurveySection;
use GPDCore\Graphql\ResolverFactory;
use GPDSurvey\Entities\Survey;
use GPDSurvey\Entities\SurveyConfiguration;

class ResolversSurveySection
{

    public static function getSurveyResolver(?callable $proxy): callable
    {
        $entityBuffer = new EntityDataLoader(Survey::class, Survey::RELATIONS_MANY_TO_ONE);
        $resolver = ResolverFactory::forEntity($entityBuffer, 'survey');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
    public static function getContentResolver(?callable $proxy): callable
    {
        $entityBuffer = new EntityDataLoader(SurveyContent::class, SurveyContent::RELATIONS_MANY_TO_ONE);
        $resolver = ResolverFactory::forEntity($entityBuffer, 'content');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
    public static function getPresentationResolver(?callable $proxy): callable
    {
        $presentationsBuffer = new EntityDataLoader(SurveyConfiguration::class, SurveyConfiguration::RELATIONS_MANY_TO_ONE);
        $resolver = ResolverFactory::forEntity($presentationsBuffer, 'presentation');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
    public static function getItemsResolver(?callable $proxy): callable
    {
        $resolver = ResolverFactory::forCollection(SurveySection::class, 'items');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
}
