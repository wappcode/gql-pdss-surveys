<?php

declare(strict_types=1);

namespace GPDSurvey\Graphql;

use GPDCore\Library\EntityBuffer;
use GPDSurvey\Entities\SurveyContent;
use GPDCore\Library\ResolverFactory;
use GPDSurvey\Graphql\BufferSurveyContent;
use GPDSurvey\Entities\SurveyConfiguration;
use GPDSurvey\Graphql\BufferSurveyQuestion;
use GPDSurvey\Graphql\BufferSurveyConfiguration;


class ResolversSurveyQuestionOption
{
    public static function getPresentationResolver(?callable $proxy): callable
    {
        $presentationsBuffer = new EntityBuffer(SurveyConfiguration::class, SurveyConfiguration::RELATIONS_MANY_TO_ONE);
        $resolver = ResolverFactory::createEntityResolver($presentationsBuffer, 'presentation');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }

    public static function getContentResolver(?callable $proxy): callable
    {
        $entityBuffer = new EntityBuffer(SurveyContent::class, SurveyContent::RELATIONS_MANY_TO_ONE);
        $resolver = ResolverFactory::createEntityResolver($entityBuffer, 'content');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
    public static function getQuestionResolver(?callable $proxy): callable
    {
        $resolver = ResolverFactory::createEntityResolver(BufferSurveyQuestion::getInstance(), 'question');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
}
