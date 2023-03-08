<?php

declare(strict_types=1);

namespace GPDSurvey\Graphql;

use GPDSurvey\Graphql\BufferSurvey;
use GPDCore\Library\EntityBuffer;
use GPDSurvey\Entities\SurveyContent;
use GPDSurvey\Entities\SurveyQuestion;
use GPDCore\Library\ResolverFactory;
use GPDSurvey\Entities\Survey;
use GPDSurvey\Graphql\BufferSurveyContent;
use GPDSurvey\Entities\SurveyConfiguration;
use GPDSurvey\Entities\SurveyQuestionOption;
use GPDSurvey\Graphql\BufferSurveyConfiguration;

class ResolversSurveyQuestion
{
    public static function getOptionsResolver(?callable $proxy): callable
    {
        $resolver = ResolverFactory::createCollectionResolver(SurveyQuestion::class, 'options', SurveyQuestionOption::RELATIONS_MANY_TO_ONE);
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
    public static function getSurveyResolver(?callable $proxy): callable
    {
        $entityBuffer = new EntityBuffer(Survey::class, Survey::RELATIONS_MANY_TO_ONE);
        $resolver = ResolverFactory::createEntityResolver($entityBuffer, 'survey');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
    public static function getAnswerScoreResolver(?callable $proxy): callable
    {
        $presentationsBuffer = new EntityBuffer(SurveyConfiguration::class, SurveyConfiguration::RELATIONS_MANY_TO_ONE);
        $resolver = ResolverFactory::createEntityResolver($presentationsBuffer, 'answerScore');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
    public static function getContentResolver(?callable $proxy): callable
    {
        $entityBuffer = new EntityBuffer(SurveyContent::class, SurveyContent::RELATIONS_MANY_TO_ONE);
        $resolver = ResolverFactory::createEntityResolver($entityBuffer, 'content');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
    public static function getPresentationResolver(?callable $proxy): callable
    {
        $presentationsBuffer = new EntityBuffer(SurveyConfiguration::class, SurveyConfiguration::RELATIONS_MANY_TO_ONE);
        $resolver = ResolverFactory::createEntityResolver($presentationsBuffer, 'presentation');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
    public static function getValidatorsResolver(?callable $proxy): callable
    {
        $validatorsBuffer = new EntityBuffer(SurveyConfiguration::class, SurveyConfiguration::RELATIONS_MANY_TO_ONE);
        $resolver = ResolverFactory::createEntityResolver($validatorsBuffer, 'validators');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
}
