<?php

namespace GPDSurvey;

use GPDCore\Library\AbstractModule;
use GPDSurvey\Graphql\ResolversSurvey;
use GPDSurvey\Graphql\ResolversSurveyAnswer;
use GPDSurvey\Graphql\ResolversSurveyContent;
use GPDSurvey\Graphql\ResolversSurveySection;
use GPDSurvey\Graphql\ResolversSurveyQuestion;
use GPDSurvey\Graphql\ResolversSurveySectionItem;
use GPDSurvey\Graphql\ResolversSurveyAnswerSession;
use GPDSurvey\Graphql\ResolversSurveyTargetAudience;
use GPDSurvey\Graphql\Types\SurveySaveAnswerInputType;

class SurveyModule extends AbstractModule
{

    function getConfig(): array
    {
        return require __DIR__ . '/../config/module.config.php';
    }
    function getServicesAndGQLTypes(): array
    {
        return [
            'factories' => [
                SurveySaveAnswerInputType::class => function ($sm) {
                    return new SurveySaveAnswerInputType();
                },
            ]
        ];
    }
    function getResolvers(): array
    {
        return [
            'Survey::questions' => ResolversSurvey::getQuestionResolver(null),
            'Survey::sections' => ResolversSurvey::getSectionResolver(null),
            'Survey::targetAudiences' => ResolversSurvey::getSectionResolver(null),
            'SurveyAnswer::question' => ResolversSurveyAnswer::getQuestionResolver(null),
            'SurveyAnswer::session' => ResolversSurveyAnswer::getSessionResolver(null),
            'SurveyAnswerSession::survey' => ResolversSurveyAnswerSession::getSurveyResolver(null),
            'SurveyAnswerSession::targetAudience' => ResolversSurveyAnswerSession::getTargetAudienceResolver(null),
            'SurveyAnswerSession::answers' => ResolversSurveyAnswerSession::getAnswersResolver(null),
            'SurveyContent::presentation' => ResolversSurveyContent::getPresentationResolver(null),
            'SurveyQuestion::options' => ResolversSurveyQuestion::getOptionsResolver(null),
            'SurveyQuestion::survey' => ResolversSurveyQuestion::getSurveyResolver(null),
            'SurveyQuestion::content' => ResolversSurveyQuestion::getContentResolver(null),
            'SurveyQuestion::answerScore' => ResolversSurveyQuestion::getAnswerScoreResolver(null),
            'SurveyQuestion::presentation' => ResolversSurveyQuestion::getPresentationResolver(null),
            'SurveyQuestion::validators' => ResolversSurveyQuestion::getValidatorsResolver(null),
            'SurveySection::presentation' => ResolversSurveySection::getPresentationResolver(null),
            'SurveySection::content' => ResolversSurveySection::getContentResolver(null),
            'SurveySection::items' => ResolversSurveySection::getItemsResolver(null),
            'SurveySection::survey' => ResolversSurveySection::getSurveyResolver(null),
            'SurveySectionItem::section' => ResolversSurveySectionItem::getSectionResolver(null),
            'SurveySectionItem::content' => ResolversSurveySectionItem::getContentResolver(null),
            'SurveySectionItem::question' => ResolversSurveySectionItem::getQuestionResolver(null),
            'SurveySectionItem::conditions' => ResolversSurveySectionItem::getConditionsResolver(null),
            'SurveyTargetAudience::survey' => ResolversSurveyTargetAudience::getSurveyResolver(null),
            'SurveyTargetAudience::presentation' => ResolversSurveyTargetAudience::getPresentationResolver(null),
            'SurveyTargetAudience::welcome' => ResolversSurveyTargetAudience::getWelcomeResolver(null),
            'SurveyTargetAudience::farewell' => ResolversSurveyTargetAudience::getFarewellResolver(null),

        ];
    }
    function getQueryFields(): array
    {
        return [];
    }
    function getMutationFields(): array
    {
        return [];
    }
}
