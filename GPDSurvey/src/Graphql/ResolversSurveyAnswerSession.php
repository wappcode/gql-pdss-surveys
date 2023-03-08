<?php

declare(strict_types=1);

namespace GPDSurvey\Graphql;

use GPDCore\Library\EntityBuffer;
use GPDSurvey\Entities\SurveyAnswer;
use GPDCore\Library\ResolverFactory;
use GPDSurvey\Entities\Survey;
use GPDSurvey\Entities\SurveyAnswerSession;
use GPDSurvey\Entities\SurveyTargetAudience;

class ResolversSurveyAnswerSession
{

    public static function getAnswersResolver(?callable $proxy): callable
    {
        $resolver = ResolverFactory::createCollectionResolver(SurveyAnswerSession::class, 'answers', SurveyAnswer::RELATIONS_MANY_TO_ONE);
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }

    public static function getTargetAudienceResolver(?callable $proxy): callable
    {
        $entityBuffer = new EntityBuffer(SurveyTargetAudience::class, SurveyTargetAudience::RELATIONS_MANY_TO_ONE);
        $resolver = ResolverFactory::createEntityResolver($entityBuffer, 'targetAudience');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
    public static function getSurveyResolver(?callable $proxy): callable
    {
        $entityBuffer = new EntityBuffer(Survey::class, Survey::RELATIONS_MANY_TO_ONE);
        $resolver = ResolverFactory::createEntityResolver($entityBuffer, 'survey');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
}
