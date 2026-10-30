<?php

namespace GPDSurvey;

use GPDCore\Core\AbstractModule;
use GPDCore\Graphql\ResolverFactory;
use GPDSurvey\Infrastructure\Doctrine\Entities\Survey;
use GPDSurvey\Infrastructure\Doctrine\Entities\SurveyAnswer;
use GPDSurvey\Infrastructure\Doctrine\Entities\SurveyAnswerSession;
use GPDSurvey\Infrastructure\Doctrine\Entities\SurveyConfiguration;
use GPDSurvey\Infrastructure\Doctrine\Entities\SurveyContent;
use GPDSurvey\Infrastructure\Doctrine\Entities\SurveyQuestion;
use GPDSurvey\Infrastructure\Doctrine\Entities\SurveyQuestionOption;
use GPDSurvey\Infrastructure\Doctrine\Entities\SurveySection;
use GPDSurvey\Infrastructure\Doctrine\Entities\SurveySectionItem;
use GPDSurvey\Infrastructure\Doctrine\Entities\SurveyTargetAudience;
use GPDSurvey\Graphql\FieldFindAnswerSessionByOwnerCode;
use GPDSurvey\Graphql\FieldFindAnswerSessionByUsernameAndPassword;

class GPDSurveyModule extends AbstractModule
{


    /**
     * Array con la configuración del módulo
     *
     * @return array
     */
    function getConfig(): array
    {
        return require(__DIR__ . '/../config/module.config.php');
    }
    function getSchema(): string
    {
        return file_get_contents(__DIR__ . '/../config/gql-pdss.graphqls') ?: '';
    }
    function getServices(): array
    {
        return [
            'invokables' => [],
            'factories' => [],
            'aliases' => []
        ];
    }
    /**
     * Array con los resolvers del módulo
     *
     * @return array array(string $key => callable $resolver)
     */
    function getResolvers(): array
    {
        return [
            'Query::getSurveys' => ResolverFactory::forConnection(Survey::class),
            'Query::getSurvey' => ResolverFactory::forItem(Survey::class,),
            'Query::getSurveyTargetAudiences' => ResolverFactory::forConnection(SurveyTargetAudience::class),
            'Query::getSurveyTargetAudience' => ResolverFactory::forItem(SurveyTargetAudience::class,),
            'Query::getSurveyAnswers' => ResolverFactory::forConnection(SurveyAnswer::class),
            'Query::getSurveyAnswer' => ResolverFactory::forItem(SurveyAnswer::class,),
            'Query::getSurveyConfigurations' => ResolverFactory::forConnection(SurveyConfiguration::class),
            'Query::getSurveyConfiguration' => ResolverFactory::forItem(SurveyConfiguration::class,),
            'Query::getSurveyContents' => ResolverFactory::forConnection(SurveyContent::class),
            'Query::getSurveyContent' => ResolverFactory::forItem(SurveyContent::class,),
            'Query::getSurveyQuestions' => ResolverFactory::forConnection(SurveyQuestion::class),
            'Query::getSurveyQuestion' => ResolverFactory::forItem(SurveyQuestion::class,),
            'Query::getSurveyQuestionOptions' => ResolverFactory::forConnection(SurveyQuestionOption::class),
            'Query::getSurveyQuestionOption' => ResolverFactory::forItem(SurveyQuestionOption::class,),
            'Query::getSurveySections' => ResolverFactory::forConnection(SurveySection::class),
            'Query::getSurveySection' => ResolverFactory::forItem(SurveySection::class,),
            'Query::getSurveySectionItems' => ResolverFactory::forConnection(SurveySectionItem::class),
            'Query::getSurveySectionItem' => ResolverFactory::forItem(SurveySectionItem::class,),
            'Query::getSurveyAnswerSessions' => ResolverFactory::forConnection(SurveyAnswerSession::class),
            'Query::getSurveyAnswerSession' => ResolverFactory::forItem(SurveyAnswerSession::class,),
            // 'findSurveyAnswerSessionByUsernameAndPassword' => FieldFindAnswerSessionByUsernameAndPassword::get($this->context, $proxy = null),
            // 'findSurveyAnswerSessionByOwnerCode' => FieldFindAnswerSessionByOwnerCode::get($this->context, $proxy = null),
        ];
    }
    public function getMiddlewares(): array
    {

        return [];
    }
    /**
     * Array con los tipos scalar graphql del módulo. El indice se utiliza como nombre del tipo.
     *
     * @return array<string, ScalarType | class-string<ScalarType>>
     */
    public function getTypes(): array
    {


        return [];
    }
    /**
     * Array con las rutas REST del módulo. El indice se utiliza como path de la ruta.
     *
     * @return array<GPDCore\Routing\RouteModel>
     */
    public function getRoutes(): array
    {
        return [];
    }
    // function getServicesAndGQLTypes(): array
    // {
    //     return [
    //         'invokables' => [
    //             TypeSurveyConfigurationValue::class => TypeSurveyConfigurationValue::class,
    //             TypeSurveyAnswerQuestionInput::class => TypeSurveyAnswerQuestionInput::class,
    //             TypeBuildSurveyInput::class => TypeBuildSurveyInput::class,
    //             TypeSurveySectionItemType::class => TypeSurveySectionItemType::class,
    //             TypeSurveyQuestionType::class => TypeSurveyQuestionType::class,
    //             TypeSurveyConfigurationType::class => TypeSurveyConfigurationType::class,
    //             TypeSurveyContentType::class => TypeSurveyContentType::class,
    //         ],
    //         'factories' => [
    //             TypeSurveyEdge::class => TypeSurveyEdge::getFactory($this->context, Survey::class),
    //             TypeSurveyConnection::class => TypeSurveyConnection::getFactory($this->context, TypeSurveyEdge::class),
    //             TypeSurveyTargetAudienceEdge::class => TypeSurveyTargetAudienceEdge::getFactory($this->context, SurveyTargetAudience::class),
    //             TypeSurveyTargetAudienceConnection::class => TypeSurveyTargetAudienceConnection::getFactory($this->context, TypeSurveyTargetAudienceEdge::class),
    //             TypeSurveyAnswerEdge::class => TypeSurveyAnswerEdge::getFactory($this->context, SurveyAnswer::class),
    //             TypeSurveyAnswerConnection::class => TypeSurveyAnswerConnection::getFactory($this->context, TypeSurveyAnswerEdge::class),
    //             TypeSurveyConfigurationEdge::class => TypeSurveyConfigurationEdge::getFactory($this->context, SurveyConfiguration::class),
    //             TypeSurveyConfigurationConnection::class => TypeSurveyConfigurationConnection::getFactory($this->context, TypeSurveyConfigurationEdge::class),
    //             TypeSurveyContentEdge::class => TypeSurveyContentEdge::getFactory($this->context, SurveyContent::class),
    //             TypeSurveyContentConnection::class => TypeSurveyContentConnection::getFactory($this->context, TypeSurveyContentEdge::class),
    //             TypeSurveyQuestionEdge::class => TypeSurveyQuestionEdge::getFactory($this->context, SurveyQuestion::class),
    //             TypeSurveyQuestionConnection::class => TypeSurveyQuestionConnection::getFactory($this->context, TypeSurveyQuestionEdge::class),
    //             TypeSurveyQuestionOptionEdge::class => TypeSurveyQuestionOptionEdge::getFactory($this->context, SurveyQuestionOption::class),
    //             TypeSurveyQuestionOptionConnection::class => TypeSurveyQuestionOptionConnection::getFactory($this->context, TypeSurveyQuestionOptionEdge::class),
    //             TypeSurveySectionEdge::class => TypeSurveySectionEdge::getFactory($this->context, SurveySection::class),
    //             TypeSurveySectionConnection::class => TypeSurveySectionConnection::getFactory($this->context, TypeSurveySectionEdge::class),
    //             TypeSurveySectionItemEdge::class => TypeSurveySectionItemEdge::getFactory($this->context, SurveySectionItem::class),
    //             TypeSurveySectionItemConnection::class => TypeSurveySectionItemConnection::getFactory($this->context, TypeSurveySectionItemEdge::class),
    //             TypeSurveyAnswerSessionEdge::class => TypeSurveyAnswerSessionEdge::getFactory($this->context, SurveyAnswerSession::class),
    //             TypeSurveyAnswerSessionConnection::class => TypeSurveyAnswerSessionConnection::getFactory($this->context, TypeSurveyAnswerSessionEdge::class),
    //             TypeBuildSurveyContentInput::class => function ($sm) {
    //                 return new TypeBuildSurveyContentInput($this->context);
    //             },
    //             TypeBuildSurveyQuestionOptionInput::class => function ($sm) {
    //                 return new TypeBuildSurveyQuestionOptionInput($this->context);
    //             },
    //             TypeBuildSurveyQuestionInput::class => function ($sm) {
    //                 return new TypeBuildSurveyQuestionInput($this->context);
    //             },
    //             TypeBuildSurveySectionItemInput::class => function ($sm) {
    //                 return new TypeBuildSurveySectionItemInput($this->context);
    //             },
    //             TypeBuildSurveySectionInput::class => function ($sm) {
    //                 return new TypeBuildSurveySectionInput($this->context);
    //             },
    //             TypeBuildSurveyTargetAudienceInput::class => function ($sm) {
    //                 return new TypeBuildSurveyTargetAudienceInput($this->context);
    //             },
    //             TypeBuildSurveyInput::class => function ($sm) {
    //                 return new TypeBuildSurveyInput($this->context);
    //             }
    //         ],
    //         'aliases' => [
    //             TypeSurveyConfigurationValue::NAME => TypeSurveyConfigurationValue::class,
    //             TypeSurveyAnswerQuestionInput::NAME => TypeSurveyAnswerQuestionInput::class,
    //             TypeBuildSurveyInput::NAME => TypeBuildSurveyInput::class,
    //             TypeSurveySectionItemType::NAME => TypeSurveySectionItemType::class,
    //             TypeSurveyQuestionType::NAME => TypeSurveyQuestionType::class,
    //             TypeSurveyConfigurationType::NAME => TypeSurveyConfigurationType::class,
    //             TypeSurveyContentType::NAME => TypeSurveyContentType::class,
    //             TypeSurveyEdge::NAME => TypeSurveyEdge::class,
    //             TypeSurveyConnection::NAME => TypeSurveyConnection::class,
    //             TypeSurveyTargetAudienceEdge::NAME => TypeSurveyTargetAudienceEdge::class,
    //             TypeSurveyTargetAudienceConnection::NAME => TypeSurveyTargetAudienceConnection::class,
    //             TypeSurveyAnswerEdge::NAME => TypeSurveyAnswerEdge::class,
    //             TypeSurveyAnswerConnection::NAME => TypeSurveyAnswerConnection::class,
    //             TypeSurveyConfigurationEdge::NAME => TypeSurveyConfigurationEdge::class,
    //             TypeSurveyConfigurationConnection::NAME => TypeSurveyConfigurationConnection::class,
    //             TypeSurveyContentEdge::NAME => TypeSurveyContentEdge::class,
    //             TypeSurveyContentConnection::NAME => TypeSurveyContentConnection::class,
    //             TypeSurveyQuestionEdge::NAME => TypeSurveyQuestionEdge::class,
    //             TypeSurveyQuestionConnection::NAME => TypeSurveyQuestionConnection::class,
    //             TypeSurveyQuestionOptionEdge::NAME => TypeSurveyQuestionOptionEdge::class,
    //             TypeSurveyQuestionOptionConnection::NAME => TypeSurveyQuestionOptionConnection::class,
    //             TypeSurveySectionEdge::NAME => TypeSurveySectionEdge::class,
    //             TypeSurveySectionConnection::NAME => TypeSurveySectionConnection::class,
    //             TypeSurveySectionItemEdge::NAME => TypeSurveySectionItemEdge::class,
    //             TypeSurveySectionItemConnection::NAME => TypeSurveySectionItemConnection::class,
    //             TypeSurveyAnswerSessionEdge::NAME => TypeSurveyAnswerSessionEdge::class,
    //             TypeSurveyAnswerSessionConnection::NAME => TypeSurveyAnswerSessionConnection::class,
    //             TypeBuildSurveyContentInput::NAME => TypeBuildSurveyContentInput::class,
    //             TypeBuildSurveyQuestionOptionInput::NAME => TypeBuildSurveyQuestionOptionInput::class,
    //             TypeBuildSurveyQuestionInput::NAME => TypeBuildSurveyQuestionInput::class,
    //             TypeBuildSurveySectionItemInput::NAME => TypeBuildSurveySectionItemInput::class,
    //             TypeBuildSurveySectionInput::NAME => TypeBuildSurveySectionInput::class,
    //             TypeBuildSurveyTargetAudienceInput::NAME => TypeBuildSurveyTargetAudienceInput::class,
    //             TypeBuildSurveyInput::NAME => TypeBuildSurveyInput::class,
    //         ]
    //     ];
    // }
    // function getResolvers(): array
    // {
    //     return [
    //         'Survey::questions' => ResolversSurvey::getQuestionResolver(null),
    //         'Survey::sections' => ResolversSurvey::getSectionResolver(null),
    //         'Survey::targetAudiences' => ResolversSurvey::getTargetAudienceResolver(null),
    //         'SurveyAnswer::question' => ResolversSurveyAnswer::getQuestionResolver(null),
    //         'SurveyAnswer::session' => ResolversSurveyAnswer::getSessionResolver(null),
    //         'SurveyAnswerSession::survey' => ResolversSurveyAnswerSession::getSurveyResolver(null),
    //         'SurveyAnswerSession::targetAudience' => ResolversSurveyAnswerSession::getTargetAudienceResolver(null),
    //         'SurveyAnswerSession::answers' => ResolversSurveyAnswerSession::getAnswersResolver(null),
    //         'SurveyContent::presentation' => ResolversSurveyContent::getPresentationResolver(null),
    //         'SurveyQuestion::options' => ResolversSurveyQuestion::getOptionsResolver(null),
    //         'SurveyQuestion::survey' => ResolversSurveyQuestion::getSurveyResolver(null),
    //         'SurveyQuestion::content' => ResolversSurveyQuestion::getContentResolver(null),
    //         'SurveyQuestion::hint' => ResolversSurveyQuestion::getHintResolver(null),
    //         'SurveyQuestion::answerScore' => ResolversSurveyQuestion::getAnswerScoreResolver(null),
    //         'SurveyQuestion::presentation' => ResolversSurveyQuestion::getPresentationResolver(null),
    //         'SurveyQuestion::validators' => ResolversSurveyQuestion::getValidatorsResolver(null),
    //         'SurveySection::presentation' => ResolversSurveySection::getPresentationResolver(null),
    //         'SurveySection::content' => ResolversSurveySection::getContentResolver(null),
    //         'SurveySection::items' => ResolversSurveySection::getItemsResolver(null),
    //         'SurveySection::survey' => ResolversSurveySection::getSurveyResolver(null),
    //         'SurveySectionItem::section' => ResolversSurveySectionItem::getSectionResolver(null),
    //         'SurveySectionItem::content' => ResolversSurveySectionItem::getContentResolver(null),
    //         'SurveySectionItem::question' => ResolversSurveySectionItem::getQuestionResolver(null),
    //         'SurveySectionItem::conditions' => ResolversSurveySectionItem::getConditionsResolver(null),
    //         'SurveyTargetAudience::survey' => ResolversSurveyTargetAudience::getSurveyResolver(null),
    //         'SurveyTargetAudience::presentation' => ResolversSurveyTargetAudience::getPresentationResolver(null),
    //         'SurveyTargetAudience::welcome' => ResolversSurveyTargetAudience::getWelcomeResolver(null),
    //         'SurveyTargetAudience::farewell' => ResolversSurveyTargetAudience::getFarewellResolver(null),
    //         'SurveyQuestionOption::content' => ResolversSurveyQuestionOption::getContentResolver(null),
    //         'SurveyQuestionOption::presentation' => ResolversSurveyQuestionOption::getPresentationResolver(null),
    //         'SurveyQuestionOption::question' => ResolversSurveyQuestionOption::getQuestionResolver(null),

    //     ];
    // }
    // //TODO: Cambiar el nombre de los campos de query agregando el prefijo get
    // function getQueryFields(): array
    // {
    //     $surveyConnection = $this->context->getServiceManager()->get(TypeSurveyConnection::class);
    //     $surveyTargetAudienceConnection = $this->context->getServiceManager()->get(TypeSurveyTargetAudienceConnection::class);
    //     $surveyAnswerConnection = $this->context->getServiceManager()->get(TypeSurveyAnswerConnection::class);
    //     $surveyConfigurationConnection = $this->context->getServiceManager()->get(TypeSurveyConfigurationConnection::class);
    //     $surveyContentConnection = $this->context->getServiceManager()->get(TypeSurveyContentConnection::class);
    //     $surveyQuestionConnection = $this->context->getServiceManager()->get(TypeSurveyQuestionConnection::class);
    //     $surveyQuestionOptionConnection = $this->context->getServiceManager()->get(TypeSurveyQuestionOptionConnection::class);
    //     $surveySectionConnection = $this->context->getServiceManager()->get(TypeSurveySectionConnection::class);
    //     $surveySectionItemConnection = $this->context->getServiceManager()->get(TypeSurveySectionItemConnection::class);
    //     $surveyAnswerSessionConnection = $this->context->getServiceManager()->get(TypeSurveyAnswerSessionConnection::class);
    //     return [
    //         'getSurveys' => ResolverFactory::forConnection(Survey::class, Survey::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'getSurvey' => ResolverFactory::forItem(Survey::class,),
    //         'getSurveyTargetAudiences' => ResolverFactory::forConnection(SurveyTargetAudience::class, SurveyTargetAudience::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'getSurveyTargetAudience' => ResolverFactory::forItem(SurveyTargetAudience::class,),
    //         'getSurveyAnswers' => ResolverFactory::forConnection(SurveyAnswer::class, SurveyAnswer::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'getSurveyAnswer' => ResolverFactory::forItem(SurveyAnswer::class,),
    //         'getSurveyConfigurations' => ResolverFactory::forConnection(SurveyConfiguration::class, SurveyConfiguration::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'getSurveyConfiguration' => ResolverFactory::forItem(SurveyConfiguration::class,),
    //         'getSurveyContents' => ResolverFactory::forConnection(SurveyContent::class, SurveyContent::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'getSurveyContent' => ResolverFactory::forItem(SurveyContent::class,),
    //         'getSurveyQuestions' => ResolverFactory::forConnection(SurveyQuestion::class, SurveyQuestion::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'getSurveyQuestion' => ResolverFactory::forItem(SurveyQuestion::class,),
    //         'getSurveyQuestionOptions' => ResolverFactory::forConnection(SurveyQuestionOption::class, SurveyQuestionOption::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'getSurveyQuestionOption' => ResolverFactory::forItem(SurveyQuestionOption::class,),
    //         'getSurveySections' => ResolverFactory::forConnection(SurveySection::class, SurveySection::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'getSurveySection' => ResolverFactory::forItem(SurveySection::class,),
    //         'getSurveySectionItems' => ResolverFactory::forConnection(SurveySectionItem::class, SurveySectionItem::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'getSurveySectionItem' => ResolverFactory::forItem(SurveySectionItem::class,),
    //         'getSurveyAnswerSessions' => ResolverFactory::forConnection(SurveyAnswerSession::class, SurveyAnswerSession::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'getSurveyAnswerSession' => ResolverFactory::forItem(SurveyAnswerSession::class,),
    //         'findSurveyAnswerSessionByUsernameAndPassword' => FieldFindAnswerSessionByUsernameAndPassword::get($this->context, $proxy = null),
    //         'findSurveyAnswerSessionByOwnerCode' => FieldFindAnswerSessionByOwnerCode::get($this->context, $proxy = null),
    //     ];
    // }
    // function getMutationFields(): array
    // {
    //     return [
    //         'buildSurvey' => FieldBuildSurvey::get($this->context, $this->defaultProxy),
    //         'createSurvey' => ResolverFactory::buildFieldCreate($this->context, Survey::class, Survey::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'updateSurvey' => ResolverFactory::buildFieldUpdate($this->context, Survey::class, Survey::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'deleteSurvey' => FieldDeleteSurvey::get($this->context, $this->defaultProxy),
    //         'buildSurveyTargetAudience' => FieldBuildSurveyTargetAudience::get($this->context,  $this->defaultProxy),
    //         'createSurveyTargetAudience' => ResolverFactory::buildFieldCreate($this->context, SurveyTargetAudience::class, SurveyTargetAudience::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'updateSurveyTargetAudience' => ResolverFactory::buildFieldUpdate($this->context, SurveyTargetAudience::class, SurveyTargetAudience::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'deleteSurveyTargetAudience' => FieldDeleteSurveyTargetAudience::get($this->context, $this->defaultProxy),
    //         'createSurveyAnswer' => ResolverFactory::buildFieldCreate($this->context, SurveyAnswer::class, SurveyAnswer::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'updateSurveyAnswer' => ResolverFactory::buildFieldUpdate($this->context, SurveyAnswer::class, SurveyAnswer::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'deleteSurveyAnswer' => ResolverFactory::buildFieldDelete($this->context, SurveyAnswer::class, SurveyAnswer::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'createSurveyConfiguration' => ResolverFactory::buildFieldCreate($this->context, SurveyConfiguration::class, SurveyConfiguration::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'updateSurveyConfiguration' => ResolverFactory::buildFieldUpdate($this->context, SurveyConfiguration::class, SurveyConfiguration::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'deleteSurveyConfiguration' => ResolverFactory::buildFieldDelete($this->context, SurveyConfiguration::class, SurveyConfiguration::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'createSurveyContent' => ResolverFactory::buildFieldCreate($this->context, SurveyContent::class, SurveyContent::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'updateSurveyContent' => ResolverFactory::buildFieldUpdate($this->context, SurveyContent::class, SurveyContent::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'deleteSurveyContent' => FieldDeleteSurveyContent::get($this->context, $this->defaultProxy),
    //         'buildSurveyQuestion' => FieldBuildSurveyQuestion::get($this->context, $this->defaultProxy),
    //         'createSurveyQuestion' => ResolverFactory::buildFieldCreate($this->context, SurveyQuestion::class, SurveyQuestion::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'updateSurveyQuestion' => ResolverFactory::buildFieldUpdate($this->context, SurveyQuestion::class, SurveyQuestion::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'deleteSurveyQuestion' => FieldDeleteSurveyQuestion::get($this->context,  $this->defaultProxy),
    //         'createSurveyQuestionOption' => ResolverFactory::buildFieldCreate($this->context, SurveyQuestionOption::class, SurveyQuestionOption::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'updateSurveyQuestionOption' => ResolverFactory::buildFieldUpdate($this->context, SurveyQuestionOption::class, SurveyQuestionOption::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'deleteSurveyQuestionOption' => FieldDeleteSurveyQuestionOption::get($this->context, $this->defaultProxy),
    //         'buildSurveySection' => FieldBuildSurveySection::get($this->context, $this->defaultProxy),
    //         'createSurveySection' => ResolverFactory::buildFieldCreate($this->context, SurveySection::class, SurveySection::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'updateSurveySection' => ResolverFactory::buildFieldUpdate($this->context, SurveySection::class, SurveySection::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'deleteSurveySection' => FieldDeleteSurveySection::get($this->context,  $this->defaultProxy),
    //         'buildSurveySectionItem' => FieldBuildSurveySectionItem::get($this->context, $this->defaultProxy),
    //         'createSurveySectionItem' => ResolverFactory::buildFieldCreate($this->context, SurveySectionItem::class, SurveySectionItem::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'updateSurveySectionItem' => ResolverFactory::buildFieldUpdate($this->context, SurveySectionItem::class, SurveySectionItem::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'deleteSurveySectionItem' => FieldDeleteSurveySectionItem::get($this->context,  $this->defaultProxy),
    //         'createSurveyAnswerSession' => FieldCreateAnswerSession::get($this->context, $proxy = null),
    //         'updateSurveyAnswerSession' => FieldUpdateAnswerSession::get($this->context, $proxy = null),
    //         'deleteSurveyAnswerSession' => FieldDeleteSurveyAnswerSession::get($this->context, $this->defaultProxy),
    //     ];
    // }
}
