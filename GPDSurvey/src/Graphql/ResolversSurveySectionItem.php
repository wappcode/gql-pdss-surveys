<?php

declare(strict_types=1);

namespace GPDSurvey\Graphql;

use GPDCore\Library\EntityBuffer;
use GPDSurvey\Entities\SurveyContent;
use GPDCore\Library\ResolverFactory;
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
        $entityBuffer = new EntityBuffer(SurveyQuestion::class, SurveyQuestion::RELATIONS_MANY_TO_ONE);
        $resolver = ResolverFactory::createEntityResolver($entityBuffer, 'question');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
    public static function getConditionsResolver(?callable $proxy): callable
    {
        $presentationsBuffer = new EntityBuffer(SurveyConfiguration::class, SurveyConfiguration::RELATIONS_MANY_TO_ONE);
        $resolver = ResolverFactory::createEntityResolver($presentationsBuffer, 'conditions');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
    public static function getSectionResolver(?callable $proxy): callable
    {
        $entityBuffer = new EntityBuffer(SurveySection::class, SurveySection::RELATIONS_MANY_TO_ONE);
        $resolver = ResolverFactory::createEntityResolver($entityBuffer, 'section');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
    public static function getContentResolver(?callable $proxy): callable
    {
        $entityBuffer = new EntityBuffer(SurveyContent::class, SurveyContent::RELATIONS_MANY_TO_ONE);
        $resolver = ResolverFactory::createEntityResolver($entityBuffer, 'content');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
}
