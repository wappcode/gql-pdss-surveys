<?php

namespace GPDSurvey;

use GPDSurvey\Entities\Survey;
use GPDCore\Library\AbstractModule;
use GPDCore\Graphql\GPDFieldFactory;
use GPDSurvey\Entities\SurveyAnswer;
use GPDSurvey\Entities\SurveyContent;
use GPDSurvey\Entities\SurveySection;
use GPDSurvey\Entities\SurveyQuestion;
use GPDSurvey\Graphql\ResolversSurvey;
use GPDSurvey\Graphql\FieldBuildSurvey;
use GPDSurvey\Entities\SurveySectionItem;
use GPDSurvey\Entities\SurveyAnswerSession;
use GPDSurvey\Entities\SurveyConfiguration;
use GPDSurvey\Graphql\Types\TypeSurveyEdge;
use GPDSurvey\Entities\SurveyQuestionOption;
use GPDSurvey\Entities\SurveyTargetAudience;
use GPDSurvey\Graphql\ResolversSurveyAnswer;
use GPDSurvey\Graphql\ResolversSurveyContent;
use GPDSurvey\Graphql\ResolversSurveySection;
use GPDSurvey\Graphql\ResolversSurveyQuestion;
use GPDSurvey\Graphql\FieldCreateAnswerSession;
use GPDSurvey\Graphql\FieldDeleteSurvey;
use GPDSurvey\Graphql\FieldUpdateAnswerSession;
use GPDSurvey\Graphql\ResolversSurveySectionItem;
use GPDSurvey\Graphql\Types\TypeBuildSurveyInput;
use GPDSurvey\Graphql\Types\TypeSurveyAnswerEdge;
use GPDSurvey\Graphql\Types\TypeSurveyConnection;
use GPDSurvey\Graphql\Types\TypeSurveyContentEdge;
use GPDSurvey\Graphql\Types\TypeSurveyContentType;
use GPDSurvey\Graphql\Types\TypeSurveySectionEdge;
use GPDSurvey\Graphql\ResolversSurveyAnswerSession;
use GPDSurvey\Graphql\Types\TypeSurveyQuestionEdge;
use GPDSurvey\Graphql\Types\TypeSurveyQuestionType;
use GPDSurvey\Graphql\ResolversSurveyTargetAudience;
use GPDSurvey\Graphql\Types\TypeSurveySectionItemEdge;
use GPDSurvey\Graphql\Types\TypeSurveySectionItemType;
use GPDSurvey\Graphql\Types\TypeSurveyAnswerConnection;
use GPDSurvey\Graphql\FieldFindAnswerSessionByOwnerCode;
use GPDSurvey\Graphql\Types\TypeBuildSurveyContentInput;
use GPDSurvey\Graphql\Types\TypeBuildSurveySectionInput;
use GPDSurvey\Graphql\Types\TypeSurveyAnswerSessionEdge;
use GPDSurvey\Graphql\Types\TypeSurveyConfigurationEdge;
use GPDSurvey\Graphql\Types\TypeSurveyConfigurationType;
use GPDSurvey\Graphql\Types\TypeSurveyContentConnection;
use GPDSurvey\Graphql\Types\TypeSurveySectionConnection;
use GPDSurvey\Graphql\Types\TypeBuildSurveyQuestionInput;
use GPDSurvey\Graphql\Types\TypeSurveyConfigurationValue;
use GPDSurvey\Graphql\Types\TypeSurveyQuestionConnection;
use GPDSurvey\Graphql\Types\TypeSurveyQuestionOptionEdge;
use GPDSurvey\Graphql\Types\TypeSurveyTargetAudienceEdge;
use GPDSurvey\Graphql\Types\TypeSurveyAnswerQuestionInput;
use GPDSurvey\Graphql\Types\TypeBuildSurveySectionItemInput;
use GPDSurvey\Graphql\Types\TypeSurveySectionItemConnection;
use GPDSurvey\Graphql\Types\TypeSurveyAnswerSessionConnection;
use GPDSurvey\Graphql\Types\TypeSurveyConfigurationConnection;
use GPDSurvey\Graphql\Types\TypeBuildSurveyQuestionOptionInput;
use GPDSurvey\Graphql\Types\TypeBuildSurveyTargetAudienceInput;
use GPDSurvey\Graphql\Types\TypeSurveyQuestionOptionConnection;
use GPDSurvey\Graphql\Types\TypeSurveyTargetAudienceConnection;
use GPDSurvey\Graphql\FieldFindAnswerSessionByUsernameAndPassword;
use GPDSurvey\Graphql\ResolversSurveyQuestionOption;

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
                TypeSurveyConfigurationValue::class => TypeSurveyConfigurationValue::class,
                TypeSurveyAnswerQuestionInput::class => TypeSurveyAnswerQuestionInput::class,
                TypeBuildSurveyInput::class => TypeBuildSurveyInput::class,
                TypeSurveySectionItemType::class => TypeSurveySectionItemType::class,
                TypeSurveyQuestionType::class => TypeSurveyQuestionType::class,
                TypeSurveyConfigurationType::class => TypeSurveyConfigurationType::class,
                TypeSurveyContentType::class => TypeSurveyContentType::class,
            ],
            'factories' => [
                TypeSurveyEdge::class => TypeSurveyEdge::getFactory($this->context, Survey::class),
                TypeSurveyConnection::class => TypeSurveyConnection::getFactory($this->context, TypeSurveyEdge::class),
                TypeSurveyTargetAudienceEdge::class => TypeSurveyTargetAudienceEdge::getFactory($this->context, SurveyTargetAudience::class),
                TypeSurveyTargetAudienceConnection::class => TypeSurveyTargetAudienceConnection::getFactory($this->context, TypeSurveyTargetAudienceEdge::class),
                TypeSurveyAnswerEdge::class => TypeSurveyAnswerEdge::getFactory($this->context, SurveyAnswer::class),
                TypeSurveyAnswerConnection::class => TypeSurveyAnswerConnection::getFactory($this->context, TypeSurveyAnswerEdge::class),
                TypeSurveyConfigurationEdge::class => TypeSurveyConfigurationEdge::getFactory($this->context, SurveyConfiguration::class),
                TypeSurveyConfigurationConnection::class => TypeSurveyConfigurationConnection::getFactory($this->context, TypeSurveyConfigurationEdge::class),
                TypeSurveyContentEdge::class => TypeSurveyContentEdge::getFactory($this->context, SurveyContent::class),
                TypeSurveyContentConnection::class => TypeSurveyContentConnection::getFactory($this->context, TypeSurveyContentEdge::class),
                TypeSurveyQuestionEdge::class => TypeSurveyQuestionEdge::getFactory($this->context, SurveyQuestion::class),
                TypeSurveyQuestionConnection::class => TypeSurveyQuestionConnection::getFactory($this->context, TypeSurveyQuestionEdge::class),
                TypeSurveyQuestionOptionEdge::class => TypeSurveyQuestionOptionEdge::getFactory($this->context, SurveyQuestionOption::class),
                TypeSurveyQuestionOptionConnection::class => TypeSurveyQuestionOptionConnection::getFactory($this->context, TypeSurveyQuestionOptionEdge::class),
                TypeSurveySectionEdge::class => TypeSurveySectionEdge::getFactory($this->context, SurveySection::class),
                TypeSurveySectionConnection::class => TypeSurveySectionConnection::getFactory($this->context, TypeSurveySectionEdge::class),
                TypeSurveySectionItemEdge::class => TypeSurveySectionItemEdge::getFactory($this->context, SurveySectionItem::class),
                TypeSurveySectionItemConnection::class => TypeSurveySectionItemConnection::getFactory($this->context, TypeSurveySectionItemEdge::class),
                TypeSurveyAnswerSessionEdge::class => TypeSurveyAnswerSessionEdge::getFactory($this->context, SurveyAnswerSession::class),
                TypeSurveyAnswerSessionConnection::class => TypeSurveyAnswerSessionConnection::getFactory($this->context, TypeSurveyAnswerSessionEdge::class),
                TypeBuildSurveyContentInput::class => function ($sm) {
                    return new TypeBuildSurveyContentInput($this->context);
                },
                TypeBuildSurveyQuestionOptionInput::class => function ($sm) {
                    return new TypeBuildSurveyQuestionOptionInput($this->context);
                },
                TypeBuildSurveyQuestionInput::class => function ($sm) {
                    return new TypeBuildSurveyQuestionInput($this->context);
                },
                TypeBuildSurveySectionItemInput::class => function ($sm) {
                    return new TypeBuildSurveySectionItemInput($this->context);
                },
                TypeBuildSurveySectionInput::class => function ($sm) {
                    return new TypeBuildSurveySectionInput($this->context);
                },
                TypeBuildSurveyTargetAudienceInput::class => function ($sm) {
                    return new TypeBuildSurveyTargetAudienceInput($this->context);
                },
                TypeBuildSurveyInput::class => function ($sm) {
                    return new TypeBuildSurveyInput($this->context);
                }
            ],
            'aliases' => [
                TypeSurveyConfigurationValue::NAME => TypeSurveyConfigurationValue::class,
                TypeSurveyAnswerQuestionInput::NAME => TypeSurveyAnswerQuestionInput::class,
                TypeBuildSurveyInput::NAME => TypeBuildSurveyInput::class,
                TypeSurveySectionItemType::NAME => TypeSurveySectionItemType::class,
                TypeSurveyQuestionType::NAME => TypeSurveyQuestionType::class,
                TypeSurveyConfigurationType::NAME => TypeSurveyConfigurationType::class,
                TypeSurveyContentType::NAME => TypeSurveyContentType::class,
                TypeSurveyEdge::NAME => TypeSurveyEdge::class,
                TypeSurveyConnection::NAME => TypeSurveyConnection::class,
                TypeSurveyTargetAudienceEdge::NAME => TypeSurveyTargetAudienceEdge::class,
                TypeSurveyTargetAudienceConnection::NAME => TypeSurveyTargetAudienceConnection::class,
                TypeSurveyAnswerEdge::NAME => TypeSurveyAnswerEdge::class,
                TypeSurveyAnswerConnection::NAME => TypeSurveyAnswerConnection::class,
                TypeSurveyConfigurationEdge::NAME => TypeSurveyConfigurationEdge::class,
                TypeSurveyConfigurationConnection::NAME => TypeSurveyConfigurationConnection::class,
                TypeSurveyContentEdge::NAME => TypeSurveyContentEdge::class,
                TypeSurveyContentConnection::NAME => TypeSurveyContentConnection::class,
                TypeSurveyQuestionEdge::NAME => TypeSurveyQuestionEdge::class,
                TypeSurveyQuestionConnection::NAME => TypeSurveyQuestionConnection::class,
                TypeSurveyQuestionOptionEdge::NAME => TypeSurveyQuestionOptionEdge::class,
                TypeSurveyQuestionOptionConnection::NAME => TypeSurveyQuestionOptionConnection::class,
                TypeSurveySectionEdge::NAME => TypeSurveySectionEdge::class,
                TypeSurveySectionConnection::NAME => TypeSurveySectionConnection::class,
                TypeSurveySectionItemEdge::NAME => TypeSurveySectionItemEdge::class,
                TypeSurveySectionItemConnection::NAME => TypeSurveySectionItemConnection::class,
                TypeSurveyAnswerSessionEdge::NAME => TypeSurveyAnswerSessionEdge::class,
                TypeSurveyAnswerSessionConnection::NAME => TypeSurveyAnswerSessionConnection::class,
                TypeBuildSurveyContentInput::NAME => TypeBuildSurveyContentInput::class,
                TypeBuildSurveyQuestionOptionInput::NAME => TypeBuildSurveyQuestionOptionInput::class,
                TypeBuildSurveyQuestionInput::NAME => TypeBuildSurveyQuestionInput::class,
                TypeBuildSurveySectionItemInput::NAME => TypeBuildSurveySectionItemInput::class,
                TypeBuildSurveySectionInput::NAME => TypeBuildSurveySectionInput::class,
                TypeBuildSurveyTargetAudienceInput::NAME => TypeBuildSurveyTargetAudienceInput::class,
                TypeBuildSurveyInput::NAME => TypeBuildSurveyInput::class,
            ]
        ];
    }
    function getResolvers(): array
    {
        return [
            'Survey::questions' => ResolversSurvey::getQuestionResolver(null),
            'Survey::sections' => ResolversSurvey::getSectionResolver(null),
            'Survey::targetAudiences' => ResolversSurvey::getTargetAudienceResolver(null),
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
            'SurveyQuestionOption::content' => ResolversSurveyQuestionOption::getContentResolver(null),
            'SurveyQuestionOption::presentation' => ResolversSurveyQuestionOption::getPresentationResolver(null),
            'SurveyQuestionOption::question' => ResolversSurveyQuestionOption::getQuestionResolver(null),

        ];
    }
    //TODO: Cambiar el nombre de los campos de query agregando el prefijo get
    function getQueryFields(): array
    {
        $surveyConnection = $this->context->getServiceManager()->get(TypeSurveyConnection::class);
        $surveyTargetAudienceConnection = $this->context->getServiceManager()->get(TypeSurveyTargetAudienceConnection::class);
        $surveyAnswerConnection = $this->context->getServiceManager()->get(TypeSurveyAnswerConnection::class);
        $surveyConfigurationConnection = $this->context->getServiceManager()->get(TypeSurveyConfigurationConnection::class);
        $surveyContentConnection = $this->context->getServiceManager()->get(TypeSurveyContentConnection::class);
        $surveyQuestionConnection = $this->context->getServiceManager()->get(TypeSurveyQuestionConnection::class);
        $surveyQuestionOptionConnection = $this->context->getServiceManager()->get(TypeSurveyQuestionOptionConnection::class);
        $surveySectionConnection = $this->context->getServiceManager()->get(TypeSurveySectionConnection::class);
        $surveySectionItemConnection = $this->context->getServiceManager()->get(TypeSurveySectionItemConnection::class);
        $surveyAnswerSessionConnection = $this->context->getServiceManager()->get(TypeSurveyAnswerSessionConnection::class);
        return [
            'getSurveys' => GPDFieldFactory::buildFieldConnection($this->context, $surveyConnection, Survey::class, Survey::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'getSurvey' => GPDFieldFactory::buildFieldItem($this->context, Survey::class, Survey::RELATIONS_MANY_TO_ONE, $proxy = null),
            'getSurveyTargetAudiences' => GPDFieldFactory::buildFieldConnection($this->context, $surveyTargetAudienceConnection, SurveyTargetAudience::class, SurveyTargetAudience::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'getSurveyTargetAudience' => GPDFieldFactory::buildFieldItem($this->context, SurveyTargetAudience::class, SurveyTargetAudience::RELATIONS_MANY_TO_ONE, $proxy = null),
            'getSurveyAnswers' => GPDFieldFactory::buildFieldConnection($this->context, $surveyAnswerConnection, SurveyAnswer::class, SurveyAnswer::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'getSurveyAnswer' => GPDFieldFactory::buildFieldItem($this->context, SurveyAnswer::class, SurveyAnswer::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'getSurveyConfigurations' => GPDFieldFactory::buildFieldConnection($this->context, $surveyConfigurationConnection, SurveyConfiguration::class, SurveyConfiguration::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'getSurveyConfiguration' => GPDFieldFactory::buildFieldItem($this->context, SurveyConfiguration::class, SurveyConfiguration::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'getSurveyContents' => GPDFieldFactory::buildFieldConnection($this->context, $surveyContentConnection, SurveyContent::class, SurveyContent::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'getSurveyContent' => GPDFieldFactory::buildFieldItem($this->context, SurveyContent::class, SurveyContent::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'getSurveyQuestions' => GPDFieldFactory::buildFieldConnection($this->context, $surveyQuestionConnection, SurveyQuestion::class, SurveyQuestion::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'getSurveyQuestion' => GPDFieldFactory::buildFieldItem($this->context, SurveyQuestion::class, SurveyQuestion::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'getSurveyQuestionOptions' => GPDFieldFactory::buildFieldConnection($this->context, $surveyQuestionOptionConnection, SurveyQuestionOption::class, SurveyQuestionOption::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'getSurveyQuestionOption' => GPDFieldFactory::buildFieldItem($this->context, SurveyQuestionOption::class, SurveyQuestionOption::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'getSurveySections' => GPDFieldFactory::buildFieldConnection($this->context, $surveySectionConnection, SurveySection::class, SurveySection::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'getSurveySection' => GPDFieldFactory::buildFieldItem($this->context, SurveySection::class, SurveySection::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'getSurveySectionItems' => GPDFieldFactory::buildFieldConnection($this->context, $surveySectionItemConnection, SurveySectionItem::class, SurveySectionItem::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'getSurveySectionItem' => GPDFieldFactory::buildFieldItem($this->context, SurveySectionItem::class, SurveySectionItem::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'getSurveyAnswerSessions' => GPDFieldFactory::buildFieldConnection($this->context, $surveyAnswerSessionConnection, SurveyAnswerSession::class, SurveyAnswerSession::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'getSurveyAnswerSession' => GPDFieldFactory::buildFieldItem($this->context, SurveyAnswerSession::class, SurveyAnswerSession::RELATIONS_MANY_TO_ONE, $proxy = null),
            'findSurveyAnswerSessionByUsernameAndPassword' => FieldFindAnswerSessionByUsernameAndPassword::get($this->context, $proxy = null),
            'findSurveyAnswerSessionByOwnerCode' => FieldFindAnswerSessionByOwnerCode::get($this->context, $proxy = null),
        ];
    }
    function getMutationFields(): array
    {
        return [
            'buildSurvey' => FieldBuildSurvey::get($this->context, $this->defaultProxy),
            'createSurvey' => GPDFieldFactory::buildFieldCreate($this->context, Survey::class, Survey::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'updateSurvey' => GPDFieldFactory::buildFieldUpdate($this->context, Survey::class, Survey::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'deleteSurvey' => FieldDeleteSurvey::get($this->context, $this->defaultProxy),
            'createSurveyTargetAudience' => GPDFieldFactory::buildFieldCreate($this->context, SurveyTargetAudience::class, SurveyTargetAudience::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'updateSurveyTargetAudience' => GPDFieldFactory::buildFieldUpdate($this->context, SurveyTargetAudience::class, SurveyTargetAudience::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'deleteSurveyTargetAudience' => GPDFieldFactory::buildFieldDelete($this->context, SurveyTargetAudience::class, SurveyTargetAudience::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'createSurveyAnswer' => GPDFieldFactory::buildFieldCreate($this->context, SurveyAnswer::class, SurveyAnswer::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'updateSurveyAnswer' => GPDFieldFactory::buildFieldUpdate($this->context, SurveyAnswer::class, SurveyAnswer::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'deleteSurveyAnswer' => GPDFieldFactory::buildFieldDelete($this->context, SurveyAnswer::class, SurveyAnswer::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'createSurveyConfiguration' => GPDFieldFactory::buildFieldCreate($this->context, SurveyConfiguration::class, SurveyConfiguration::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'updateSurveyConfiguration' => GPDFieldFactory::buildFieldUpdate($this->context, SurveyConfiguration::class, SurveyConfiguration::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'deleteSurveyConfiguration' => GPDFieldFactory::buildFieldDelete($this->context, SurveyConfiguration::class, SurveyConfiguration::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'createSurveyContent' => GPDFieldFactory::buildFieldCreate($this->context, SurveyContent::class, SurveyContent::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'updateSurveyContent' => GPDFieldFactory::buildFieldUpdate($this->context, SurveyContent::class, SurveyContent::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'deleteSurveyContent' => GPDFieldFactory::buildFieldDelete($this->context, SurveyContent::class, SurveyContent::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'createSurveyQuestion' => GPDFieldFactory::buildFieldCreate($this->context, SurveyQuestion::class, SurveyQuestion::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'updateSurveyQuestion' => GPDFieldFactory::buildFieldUpdate($this->context, SurveyQuestion::class, SurveyQuestion::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'deleteSurveyQuestion' => GPDFieldFactory::buildFieldDelete($this->context, SurveyQuestion::class, SurveyQuestion::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'createSurveyQuestionOption' => GPDFieldFactory::buildFieldCreate($this->context, SurveyQuestionOption::class, SurveyQuestionOption::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'updateSurveyQuestionOption' => GPDFieldFactory::buildFieldUpdate($this->context, SurveyQuestionOption::class, SurveyQuestionOption::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'deleteSurveyQuestionOption' => GPDFieldFactory::buildFieldDelete($this->context, SurveyQuestionOption::class, SurveyQuestionOption::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'createSurveySection' => GPDFieldFactory::buildFieldCreate($this->context, SurveySection::class, SurveySection::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'updateSurveySection' => GPDFieldFactory::buildFieldUpdate($this->context, SurveySection::class, SurveySection::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'deleteSurveySection' => GPDFieldFactory::buildFieldDelete($this->context, SurveySection::class, SurveySection::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'createSurveySectionItem' => GPDFieldFactory::buildFieldCreate($this->context, SurveySectionItem::class, SurveySectionItem::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'updateSurveySectionItem' => GPDFieldFactory::buildFieldUpdate($this->context, SurveySectionItem::class, SurveySectionItem::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'deleteSurveySectionItem' => GPDFieldFactory::buildFieldDelete($this->context, SurveySectionItem::class, SurveySectionItem::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
            'createSurveyAnswerSession' => FieldCreateAnswerSession::get($this->context, $proxy = null),
            'updateSurveyAnswerSession' => FieldUpdateAnswerSession::get($this->context, $proxy = null),
            'deleteSurveyAnswerSession' => GPDFieldFactory::buildFieldDelete($this->context, SurveyAnswerSession::class, SurveyAnswerSession::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
        ];
    }
}
