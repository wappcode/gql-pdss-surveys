<?php

declare(strict_types=1);

namespace GPDSurvey\Graphql;

use GPDCore\Graphql\ResolverFactory;
use GPDSurvey\Entities\Survey;

class ResolversSurvey
{

    public static function getQuestionResolver(?callable $proxy): callable
    {
        $resolver = ResolverFactory::forCollection(Survey::class, 'questions');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
    public static function getSectionResolver(?callable $proxy): callable
    {
        $resolver = ResolverFactory::forCollection(Survey::class, 'sections');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
    public static function getTargetAudienceResolver(?callable $proxy): callable
    {
        $resolver = ResolverFactory::forCollection(Survey::class, 'targetAudiences');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
}
