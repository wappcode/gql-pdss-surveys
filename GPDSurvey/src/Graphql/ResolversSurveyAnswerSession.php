<?php

declare(strict_types=1);

namespace GPDSurvey\Graphql;

use GPDCore\DataLoaders\EntityDataLoader;
use GPDCore\Graphql\ResolverFactory;
use GPDSurvey\Entities\Survey;
use GPDSurvey\Entities\SurveyAnswerSession;
use GPDSurvey\Entities\SurveyTargetAudience;

class ResolversSurveyAnswerSession
{

    public static function getAnswersResolver(?callable $proxy): callable
    {
        $resolver = ResolverFactory::forCollection(SurveyAnswerSession::class, 'answers');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }

    public static function getTargetAudienceResolver(?callable $proxy): callable
    {
        $entityBuffer = new EntityDataLoader(SurveyTargetAudience::class, SurveyTargetAudience::RELATIONS_MANY_TO_ONE);
        $resolver = ResolverFactory::forEntity($entityBuffer, 'targetAudience');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
    public static function getSurveyResolver(?callable $proxy): callable
    {
        $entityBuffer = new EntityDataLoader(Survey::class, Survey::RELATIONS_MANY_TO_ONE);
        $resolver = ResolverFactory::forEntity($entityBuffer, 'survey');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
}
