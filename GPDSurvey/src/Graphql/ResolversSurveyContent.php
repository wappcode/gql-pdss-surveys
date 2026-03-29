<?php

declare(strict_types=1);

namespace GPDSurvey\Graphql;

use GPDCore\DataLoaders\EntityDataLoader;
use GPDCore\Graphql\ResolverFactory;
use GPDSurvey\Entities\SurveyConfiguration;
use GPDSurvey\Graphql\BufferSurveyConfiguration;

class ResolversSurveyContent
{

    public static function getPresentationResolver(?callable $proxy): callable
    {
        $presentationsBuffer = new EntityDataLoader(SurveyConfiguration::class, SurveyConfiguration::RELATIONS_MANY_TO_ONE);
        $resolver = ResolverFactory::forEntity($presentationsBuffer, 'presentation');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
}
