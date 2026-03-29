<?php

declare(strict_types=1);

namespace GPDSurvey\Graphql;

use GPDCore\DataLoaders\EntityDataLoader;
use GPDSurvey\Entities\SurveyContent;
use GPDCore\Graphql\ResolverFactory;
use GPDSurvey\Entities\Survey;
use GPDSurvey\Entities\SurveyConfiguration;

class ResolversSurveyTargetAudience
{
    public static function getWelcomeResolver(?callable $proxy): callable
    {
        $entityBuffer = new EntityDataLoader(SurveyContent::class, SurveyContent::RELATIONS_MANY_TO_ONE);
        $resolver = ResolverFactory::forEntity($entityBuffer, 'welcome');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
    public static function getFarewellResolver(?callable $proxy): callable
    {
        $entityBuffer = new EntityDataLoader(SurveyContent::class, SurveyContent::RELATIONS_MANY_TO_ONE);
        $resolver = ResolverFactory::forEntity($entityBuffer, 'farewell');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
    public static function getSurveyResolver(?callable $proxy): callable
    {
        $entityBuffer = new EntityDataLoader(Survey::class, Survey::RELATIONS_MANY_TO_ONE);
        $resolver = ResolverFactory::forEntity($entityBuffer, 'survey');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
    public static function getPresentationResolver(?callable $proxy): callable
    {
        $presentationsBuffer = new EntityDataLoader(SurveyConfiguration::class, SurveyConfiguration::RELATIONS_MANY_TO_ONE);
        $resolver = ResolverFactory::forEntity($presentationsBuffer, 'presentation');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
}
