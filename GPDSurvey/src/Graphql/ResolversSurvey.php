<?php

declare(strict_types=1);

namespace GPDSurvey\Graphql;

use GPDCore\Library\ResolverFactory;
use GPDSurvey\Infrastructure\Doctrine\Entities\Survey;
use GPDSurvey\Infrastructure\Doctrine\Entities\SurveyQuestion;
use GPDSurvey\Infrastructure\Doctrine\Entities\SurveySection;
use GPDSurvey\Infrastructure\Doctrine\Entities\SurveyTargetAudience;

class ResolversSurvey
{

    public static function getQuestionResolver(?callable $proxy): callable
    {
        $resolver = ResolverFactory::createCollectionResolver(Survey::class, 'questions', SurveyQuestion::RELATIONS_MANY_TO_ONE);
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
    public static function getSectionResolver(?callable $proxy): callable
    {
        $resolver = ResolverFactory::createCollectionResolver(Survey::class, 'sections', SurveySection::RELATIONS_MANY_TO_ONE);
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
    public static function getTargetAudienceResolver(?callable $proxy): callable
    {
        $resolver = ResolverFactory::createCollectionResolver(Survey::class, 'targetAudiences', SurveyTargetAudience::RELATIONS_MANY_TO_ONE);
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
}
