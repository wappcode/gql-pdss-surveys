<?php

declare(strict_types=1);

namespace GPDSurvey\Graphql;

use GPDSurvey\Graphql\BufferSurvey;
use GPDCore\DataLoaders\EntityDataLoader;
use GPDSurvey\Entities\SurveyContent;
use GPDSurvey\Entities\SurveyQuestion;
use GPDCore\Graphql\ResolverFactory;
use GPDSurvey\Entities\Survey;
use GPDSurvey\Entities\SurveyConfiguration;


class ResolversSurveyQuestion
{
    public static function getOptionsResolver(?callable $proxy): callable
    {
        $resolver = ResolverFactory::forCollection(SurveyQuestion::class, 'options');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
    public static function getSurveyResolver(?callable $proxy): callable
    {
        $entityBuffer = new EntityDataLoader(Survey::class, Survey::RELATIONS_MANY_TO_ONE);
        $resolver = ResolverFactory::forEntity($entityBuffer, 'survey');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
    public static function getAnswerScoreResolver(?callable $proxy): callable
    {
        $presentationsBuffer = new EntityDataLoader(SurveyConfiguration::class, SurveyConfiguration::RELATIONS_MANY_TO_ONE);
        $resolver = ResolverFactory::forEntity($presentationsBuffer, 'answerScore');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
    public static function getContentResolver(?callable $proxy): callable
    {
        $entityBuffer = new EntityDataLoader(SurveyContent::class, SurveyContent::RELATIONS_MANY_TO_ONE);
        $resolver = ResolverFactory::forEntity($entityBuffer, 'content');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
    public static function getHintResolver(?callable $proxy): callable
    {
        $entityBuffer = new EntityDataLoader(SurveyContent::class, SurveyContent::RELATIONS_MANY_TO_ONE);
        $resolver = ResolverFactory::forEntity($entityBuffer, 'hint');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
    public static function getPresentationResolver(?callable $proxy): callable
    {
        $presentationsBuffer = new EntityDataLoader(SurveyConfiguration::class, SurveyConfiguration::RELATIONS_MANY_TO_ONE);
        $resolver = ResolverFactory::forEntity($presentationsBuffer, 'presentation');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
    public static function getValidatorsResolver(?callable $proxy): callable
    {
        $validatorsBuffer = new EntityDataLoader(SurveyConfiguration::class, SurveyConfiguration::RELATIONS_MANY_TO_ONE);
        $resolver = ResolverFactory::forEntity($validatorsBuffer, 'validators');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
}
