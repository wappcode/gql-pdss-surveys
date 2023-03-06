<?php

namespace GPDSurvey;

use GPDSurvey\Entities\Survey;
use GPDCore\Library\AbstractModule;
use GPDCore\Graphql\GPDFieldFactory;
use GPDSurvey\Graphql\ResolversSurvey;
use GPDSurvey\Graphql\Types\TypeSurveyEdge;
use GPDSurvey\Entities\SurveyTargetAudience;
use GPDSurvey\Graphql\ResolversSurveyAnswer;
use GPDSurvey\Graphql\ResolversSurveyContent;
use GPDSurvey\Graphql\ResolversSurveySection;
use GPDSurvey\Graphql\ResolversSurveyQuestion;
use GPDSurvey\Graphql\ResolversSurveySectionItem;
use GPDSurvey\Graphql\Types\TypeSurveyConnection;
use GPDSurvey\Graphql\ResolversSurveyAnswerSession;
use GPDSurvey\Graphql\ResolversSurveyTargetAudience;
use GPDSurvey\Graphql\Types\SurveySaveAnswerInputType;
use GPDSurvey\Graphql\Types\TypeSurveyTargetAudienceEdge;
use GPDSurvey\Graphql\Types\TypeSurveyTargetAudienceConnection;

class GPDSurveyModule extends AbstractModule
{

    /**
     * Sobreescribir esta propiedad para agregar seguridad a todo el módulo excepto a los campos utilizados para que las personas contesten un cuestionario 
     * Para poner seguridad en estos campos en necesario sobreescribirlos
     *
     * @var ?callable
     */
    protected $defaultProxy = null;
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
                TypeSurveyEdge::NAME => TypeSurveyEdge::getFactory($this->context, Survey::class),
                TypeSurveyConnection::NAME => TypeSurveyConnection::getFactory($this->context, TypeSurveyEdge::NAME),
                TypeSurveyTargetAudienceEdge::NAME => TypeSurveyTargetAudienceEdge::getFactory($this->context, SurveyTargetAudience::class),
                TypeSurveyTargetAudienceConnection::NAME => TypeSurveyTargetAudienceConnection::getFactory($this->context, TypeSurveyTargetAudienceEdge::NAME)
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
        $surveyConnection = $this->context->getServiceManager()->get(TypeSurveyConnection::NAME);
        $surveyTargetAudienceConnection = $this->context->getServiceManager()->get(TypeSurveyTargetAudienceConnection::NAME);
        return [
            'surveysConnection' => GPDFieldFactory::buildFieldConnection($this->context, $surveyConnection, Survey::class, Survey::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'survey' => GPDFieldFactory::buildFieldItem($this->context, Survey::class, Survey::RELATIONS_MANY_TO_ONE, $proxy = null),
            'createSurvey' => GPDFieldFactory::buildFieldCreate($this->context, Survey::class, Survey::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'updateSurvey' => GPDFieldFactory::buildFieldUpdate($this->context, Survey::class, Survey::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'deleteSurvey' => GPDFieldFactory::buildFieldDelete($this->context, Survey::class, Survey::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'surveyTargetAudienceConnection' => GPDFieldFactory::buildFieldConnection($this->context, $surveyTargetAudienceConnection, SurveyTargetAudience::class, SurveyTargetAudience::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'surveyTargetAudience' => GPDFieldFactory::buildFieldItem($this->context, SurveyTargetAudience::class, SurveyTargetAudience::RELATIONS_MANY_TO_ONE, $proxy = null),
            'createSurveyTargetAudience' => GPDFieldFactory::buildFieldCreate($this->context, SurveyTargetAudience::class, SurveyTargetAudience::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'updateSurveyTargetAudience' => GPDFieldFactory::buildFieldUpdate($this->context, SurveyTargetAudience::class, SurveyTargetAudience::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'deleteSurveyTargetAudience' => GPDFieldFactory::buildFieldDelete($this->context, SurveyTargetAudience::class, SurveyTargetAudience::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
        ];
    }
    function getMutationFields(): array
    {
        return [];
    }
}
