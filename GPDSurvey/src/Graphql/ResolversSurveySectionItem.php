<?php

declare(strict_types=1);

namespace GPDSurvey\Graphql;

use GPDCore\DataLoaders\EntityDataLoader;
use GPDSurvey\Entities\SurveyContent;
use GPDCore\Graphql\ResolverFactory;
use GPDSurvey\Graphql\BufferSurveyContent;
use GPDSurvey\Graphql\BufferSurveySection;
use GPDSurvey\Entities\SurveyConfiguration;
use GPDSurvey\Entities\SurveyQuestion;
use GPDSurvey\Entities\SurveySection;
use GPDSurvey\Graphql\BufferSurveyQuestion;
use GPDSurvey\Graphql\BufferSurveyConfiguration;

class ResolversSurveySectionItem
{


    // 'conditions', 'section', 'question', 'content'
    public static function getQuestionResolver(?callable $proxy): callable
    {
        $entityBuffer = new EntityDataLoader(SurveyQuestion::class, SurveyQuestion::RELATIONS_MANY_TO_ONE);
        $resolver = ResolverFactory::forEntity($entityBuffer, 'question');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
    public static function getConditionsResolver(?callable $proxy): callable
    {
        $presentationsBuffer = new EntityDataLoader(SurveyConfiguration::class, SurveyConfiguration::RELATIONS_MANY_TO_ONE);
        $resolver = ResolverFactory::forEntity($presentationsBuffer, 'conditions');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
    public static function getSectionResolver(?callable $proxy): callable
    {
        $entityBuffer = new EntityDataLoader(SurveySection::class, SurveySection::RELATIONS_MANY_TO_ONE);
        $resolver = ResolverFactory::forEntity($entityBuffer, 'section');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
    public static function getContentResolver(?callable $proxy): callable
    {
        $entityBuffer = new EntityDataLoader(SurveyContent::class, SurveyContent::RELATIONS_MANY_TO_ONE);
        $resolver = ResolverFactory::forEntity($entityBuffer, 'content');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
}
