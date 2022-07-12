<?php

declare(strict_types=1);

namespace GPDSurvey\Graphql;

use GPDSurvey\Graphql\BufferSurvey;
use GPDSurvey\Entities\SurveyAnswer;
use GPDCore\Library\ResolverFactory;
use GPDSurvey\Entities\SurveyAnswerSession;
use GPDSurvey\Graphql\BufferSurveyTargetAudience;

class ResolversSurveyAnswerSession
{

    public static function getAnswersResolver(?callable $proxy): callable
    {
        $resolver = ResolverFactory::createCollectionResolver(SurveyAnswerSession::class, 'answers', SurveyAnswer::RELATIONS_MANY_TO_ONE);
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }

    public static function getTargetAudienceResolver(?callable $proxy): callable
    {
        $resolver = ResolverFactory::createEntityResolver(BufferSurveyTargetAudience::getInstance(), 'targetAudience');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
    public static function getSurveyResolver(?callable $proxy): callable
    {
        $resolver = ResolverFactory::createEntityResolver(BufferSurvey::getInstance(), 'survey');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
}
