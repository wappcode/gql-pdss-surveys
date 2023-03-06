<?php

namespace GPDSurvey;

use GPDSurvey\Entities\Survey;
use GPDCore\Library\AbstractModule;
use GPDCore\Graphql\GPDFieldFactory;
use GPDSurvey\Entities\SurveyAnswer;
use GPDSurvey\Entities\SurveyContent;
use GPDSurvey\Entities\SurveyQuestion;
use GPDSurvey\Graphql\ResolversSurvey;
use GPDSurvey\Entities\SurveyConfiguration;
use GPDSurvey\Graphql\Types\TypeSurveyEdge;
use GPDSurvey\Entities\SurveyTargetAudience;
use GPDSurvey\Graphql\ResolversSurveyAnswer;
use GPDSurvey\Graphql\ResolversSurveyContent;
use GPDSurvey\Graphql\ResolversSurveySection;
use GPDSurvey\Graphql\ResolversSurveyQuestion;
use GPDSurvey\Graphql\ResolversSurveySectionItem;
use GPDSurvey\Graphql\Types\TypeSurveyAnswerEdge;
use GPDSurvey\Graphql\Types\TypeSurveyConnection;
use GPDSurvey\Graphql\Types\TypeSurveyContentEdge;
use GPDSurvey\Graphql\ResolversSurveyAnswerSession;
use GPDSurvey\Graphql\Types\TypeSurveyQuestionEdge;
use GPDSurvey\Graphql\ResolversSurveyTargetAudience;
use GPDSurvey\Graphql\Types\SurveySaveAnswerInputType;
use GPDSurvey\Graphql\Types\TypeSurveyAnswerConnection;
use GPDSurvey\Graphql\Types\TypeSurveyConfigurationEdge;
use GPDSurvey\Graphql\Types\TypeSurveyContentConnection;
use GPDSurvey\Graphql\Types\TypeSurveyConfigurationValue;
use GPDSurvey\Graphql\Types\TypeSurveyQuestionConnection;
use GPDSurvey\Graphql\Types\TypeSurveyTargetAudienceEdge;
use GPDSurvey\Graphql\Types\TypeSurveyConfigurationConnection;
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
            'invokables' => [
                TypeSurveyConfigurationValue::NAME => TypeSurveyConfigurationValue::class,
            ],
            'factories' => [
                SurveySaveAnswerInputType::class => function ($sm) {
                    return new SurveySaveAnswerInputType();
                },
                TypeSurveyEdge::NAME => TypeSurveyEdge::getFactory($this->context, Survey::class),
                TypeSurveyConnection::NAME => TypeSurveyConnection::getFactory($this->context, TypeSurveyEdge::NAME),
                TypeSurveyTargetAudienceEdge::NAME => TypeSurveyTargetAudienceEdge::getFactory($this->context, SurveyTargetAudience::class),
                TypeSurveyTargetAudienceConnection::NAME => TypeSurveyTargetAudienceConnection::getFactory($this->context, TypeSurveyTargetAudienceEdge::NAME),
                TypeSurveyAnswerEdge::NAME => TypeSurveyAnswerEdge::getFactory($this->context, SurveyAnswer::class),
                TypeSurveyAnswerConnection::NAME => TypeSurveyAnswerConnection::getFactory($this->context, TypeSurveyAnswerEdge::NAME),
                TypeSurveyConfigurationEdge::NAME => TypeSurveyConfigurationEdge::getFactory($this->context, SurveyConfiguration::class),
                TypeSurveyConfigurationConnection::NAME => TypeSurveyConfigurationConnection::getFactory($this->context, TypeSurveyConfigurationEdge::NAME),
                TypeSurveyContentEdge::NAME => TypeSurveyContentEdge::getFactory($this->context, SurveyContent::class),
                TypeSurveyContentConnection::NAME => TypeSurveyContentConnection::getFactory($this->context, TypeSurveyContentEdge::NAME),
                TypeSurveyQuestionEdge::NAME => TypeSurveyQuestionEdge::getFactory($this->context, SurveyQuestion::class),
                TypeSurveyQuestionConnection::NAME => TypeSurveyQuestionConnection::getFactory($this->context, TypeSurveyQuestionEdge::NAME),
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
        $surveyAnswerConnection = $this->context->getServiceManager()->get(TypeSurveyAnswerConnection::NAME);
        $surveyConfigurationConnection = $this->context->getServiceManager()->get(TypeSurveyConfigurationConnection::NAME);
        $surveyContentConnection = $this->context->getServiceManager()->get(TypeSurveyContentConnection::NAME);
        $surveyQuestionConnection = $this->context->getServiceManager()->get(TypeSurveyQuestionConnection::NAME);
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
            'surveyAnswerConnection' => GPDFieldFactory::buildFieldConnection($this->context, $surveyAnswerConnection, SurveyAnswer::class, SurveyAnswer::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'surveyAnswer' => GPDFieldFactory::buildFieldItem($this->context, SurveyAnswer::class, SurveyAnswer::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'createSurveyAnswer' => GPDFieldFactory::buildFieldCreate($this->context, SurveyAnswer::class, SurveyAnswer::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'updateSurveyAnswer' => GPDFieldFactory::buildFieldUpdate($this->context, SurveyAnswer::class, SurveyAnswer::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'deleteSurveyAnswer' => GPDFieldFactory::buildFieldDelete($this->context, SurveyAnswer::class, SurveyAnswer::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'surveyConfigurationConnection' => GPDFieldFactory::buildFieldConnection($this->context, $surveyConfigurationConnection, SurveyConfiguration::class, SurveyConfiguration::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'surveyConfiguration' => GPDFieldFactory::buildFieldItem($this->context, SurveyConfiguration::class, SurveyConfiguration::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'createSurveyConfiguration' => GPDFieldFactory::buildFieldCreate($this->context, SurveyConfiguration::class, SurveyConfiguration::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'updateSurveyConfiguration' => GPDFieldFactory::buildFieldUpdate($this->context, SurveyConfiguration::class, SurveyConfiguration::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'deleteSurveyConfiguration' => GPDFieldFactory::buildFieldDelete($this->context, SurveyConfiguration::class, SurveyConfiguration::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'surveyContentConnection' => GPDFieldFactory::buildFieldConnection($this->context, $surveyContentConnection, SurveyContent::class, SurveyContent::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'surveyContent' => GPDFieldFactory::buildFieldItem($this->context, SurveyContent::class, SurveyContent::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'createSurveyContent' => GPDFieldFactory::buildFieldCreate($this->context, SurveyContent::class, SurveyContent::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'updateSurveyContent' => GPDFieldFactory::buildFieldUpdate($this->context, SurveyContent::class, SurveyContent::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'deleteSurveyContent' => GPDFieldFactory::buildFieldDelete($this->context, SurveyContent::class, SurveyContent::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'surveyQuestionConnection' => GPDFieldFactory::buildFieldConnection($this->context, $surveyQuestionConnection, SurveyQuestion::class, SurveyQuestion::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'surveyQuestion' => GPDFieldFactory::buildFieldItem($this->context, SurveyQuestion::class, SurveyQuestion::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'createSurveyQuestion' => GPDFieldFactory::buildFieldCreate($this->context, SurveyQuestion::class, SurveyQuestion::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'updateSurveyQuestion' => GPDFieldFactory::buildFieldUpdate($this->context, SurveyQuestion::class, SurveyQuestion::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'deleteSurveyQuestion' => GPDFieldFactory::buildFieldDelete($this->context, SurveyQuestion::class, SurveyQuestion::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
        ];
    }
    function getMutationFields(): array
    {
        return [];
    }
}
