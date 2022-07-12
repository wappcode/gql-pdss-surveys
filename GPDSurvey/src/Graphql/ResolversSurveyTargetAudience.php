<?php

declare(strict_types=1);

namespace GPDSurvey\Graphql;

use GPDSurvey\Graphql\BufferSurvey;
use GPDCore\Library\EntityBuffer;
use GPDSurvey\Entities\SurveyContent;
use GPDCore\Library\ResolverFactory;
use GPDSurvey\Graphql\BufferSurveyContent;
use GPDSurvey\Entities\SurveyConfiguration;
use GPDSurvey\Graphql\BufferSurveyConfiguration;

class ResolversSurveyTargetAudience
{
    public static function getWelcomeResolver(?callable $proxy): callable
    {
        $entityBuffer = new EntityBuffer(SurveyContent::class, SurveyContent::RELATIONS_MANY_TO_ONE);
        $resolver = ResolverFactory::createEntityResolver($entityBuffer, 'welcome');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
    public static function getFarewellResolver(?callable $proxy): callable
    {
        $entityBuffer = new EntityBuffer(SurveyContent::class, SurveyContent::RELATIONS_MANY_TO_ONE);
        $resolver = ResolverFactory::createEntityResolver($entityBuffer, 'farewell');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
    public static function getSurveyResolver(?callable $proxy): callable
    {
        $resolver = ResolverFactory::createEntityResolver(BufferSurvey::getInstance(), 'survey');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
    public static function getPresentationResolver(?callable $proxy): callable
    {
        $presentationsBuffer = new EntityBuffer(SurveyConfiguration::class, SurveyConfiguration::RELATIONS_MANY_TO_ONE);
        $resolver = ResolverFactory::createEntityResolver($presentationsBuffer, 'presentation');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
}
