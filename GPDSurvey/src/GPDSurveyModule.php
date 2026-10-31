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
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurvey;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveyAnswer;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveyAnswerSession;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveyConfiguration;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveyContent;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveyQuestion;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveyQuestionOption;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveySection;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveySectionItem;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveyTargetAudience;

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
            'Query::getSurveys' => ResolverFactory::forConnection(DoctrineSurvey::class),
            'Query::getSurvey' => ResolverFactory::forItem(DoctrineSurvey::class,),
            'Query::getSurveyTargetAudiences' => ResolverFactory::forConnection(DoctrineSurveyTargetAudience::class),
            'Query::getSurveyTargetAudience' => ResolverFactory::forItem(DoctrineSurveyTargetAudience::class,),
            'Query::getSurveyAnswers' => ResolverFactory::forConnection(DoctrineSurveyAnswer::class),
            'Query::getSurveyAnswer' => ResolverFactory::forItem(DoctrineSurveyAnswer::class,),
            'Query::getSurveyConfigurations' => ResolverFactory::forConnection(DoctrineSurveyConfiguration::class),
            'Query::getSurveyConfiguration' => ResolverFactory::forItem(DoctrineSurveyConfiguration::class,),
            'Query::getSurveyContents' => ResolverFactory::forConnection(DoctrineSurveyContent::class),
            'Query::getSurveyContent' => ResolverFactory::forItem(DoctrineSurveyContent::class,),
            'Query::getSurveyQuestions' => ResolverFactory::forConnection(DoctrineSurveyQuestion::class),
            'Query::getSurveyQuestion' => ResolverFactory::forItem(DoctrineSurveyQuestion::class,),
            'Query::getSurveyQuestionOptions' => ResolverFactory::forConnection(DoctrineSurveyQuestionOption::class),
            'Query::getSurveyQuestionOption' => ResolverFactory::forItem(DoctrineSurveyQuestionOption::class,),
            'Query::getSurveySections' => ResolverFactory::forConnection(DoctrineSurveySection::class),
            'Query::getSurveySection' => ResolverFactory::forItem(DoctrineSurveySection::class,),
            'Query::getSurveySectionItems' => ResolverFactory::forConnection(DoctrineSurveySectionItem::class),
            'Query::getSurveySectionItem' => ResolverFactory::forItem(DoctrineSurveySectionItem::class,),
            'Query::getSurveyAnswerSessions' => ResolverFactory::forConnection(DoctrineSurveyAnswerSession::class),
            'Query::getSurveyAnswerSession' => ResolverFactory::forItem(DoctrineSurveyAnswerSession::class,),
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
    //             DoctrineTypeSurveyConfigurationValue::class => DoctrineTypeSurveyConfigurationValue::class,
    //             DoctrineTypeSurveyAnswerQuestionInput::class => DoctrineTypeSurveyAnswerQuestionInput::class,
    //             DoctrineTypeBuildSurveyInput::class => DoctrineTypeBuildSurveyInput::class,
    //             DoctrineTypeSurveySectionItemType::class => DoctrineTypeSurveySectionItemType::class,
    //             DoctrineTypeSurveyQuestionType::class => DoctrineTypeSurveyQuestionType::class,
    //             DoctrineTypeSurveyConfigurationType::class => DoctrineTypeSurveyConfigurationType::class,
    //             DoctrineTypeSurveyContentType::class => DoctrineTypeSurveyContentType::class,
    //         ],
    //         'factories' => [
    //             DoctrineTypeSurveyEdge::class => TypeSurveyEdge::getFactory($this->context, DoctrineSurvey::class),
    //             DoctrineTypeSurveyConnection::class => TypeSurveyConnection::getFactory($this->context, DoctrineTypeSurveyEdge::class),
    //             DoctrineTypeSurveyTargetAudienceEdge::class => TypeSurveyTargetAudienceEdge::getFactory($this->context, DoctrineSurveyTargetAudience::class),
    //             DoctrineTypeSurveyTargetAudienceConnection::class => TypeSurveyTargetAudienceConnection::getFactory($this->context, DoctrineTypeSurveyTargetAudienceEdge::class),
    //             DoctrineTypeSurveyAnswerEdge::class => TypeSurveyAnswerEdge::getFactory($this->context, DoctrineSurveyAnswer::class),
    //             DoctrineTypeSurveyAnswerConnection::class => TypeSurveyAnswerConnection::getFactory($this->context, DoctrineTypeSurveyAnswerEdge::class),
    //             DoctrineTypeSurveyConfigurationEdge::class => TypeSurveyConfigurationEdge::getFactory($this->context, DoctrineSurveyConfiguration::class),
    //             DoctrineTypeSurveyConfigurationConnection::class => TypeSurveyConfigurationConnection::getFactory($this->context, DoctrineTypeSurveyConfigurationEdge::class),
    //             DoctrineTypeSurveyContentEdge::class => TypeSurveyContentEdge::getFactory($this->context, DoctrineSurveyContent::class),
    //             DoctrineTypeSurveyContentConnection::class => TypeSurveyContentConnection::getFactory($this->context, DoctrineTypeSurveyContentEdge::class),
    //             DoctrineTypeSurveyQuestionEdge::class => TypeSurveyQuestionEdge::getFactory($this->context, DoctrineSurveyQuestion::class),
    //             DoctrineTypeSurveyQuestionConnection::class => TypeSurveyQuestionConnection::getFactory($this->context, DoctrineTypeSurveyQuestionEdge::class),
    //             DoctrineTypeSurveyQuestionOptionEdge::class => TypeSurveyQuestionOptionEdge::getFactory($this->context, DoctrineSurveyQuestionOption::class),
    //             DoctrineTypeSurveyQuestionOptionConnection::class => TypeSurveyQuestionOptionConnection::getFactory($this->context, DoctrineTypeSurveyQuestionOptionEdge::class),
    //             DoctrineTypeSurveySectionEdge::class => TypeSurveySectionEdge::getFactory($this->context, DoctrineSurveySection::class),
    //             DoctrineTypeSurveySectionConnection::class => TypeSurveySectionConnection::getFactory($this->context, DoctrineTypeSurveySectionEdge::class),
    //             DoctrineTypeSurveySectionItemEdge::class => TypeSurveySectionItemEdge::getFactory($this->context, DoctrineSurveySectionItem::class),
    //             DoctrineTypeSurveySectionItemConnection::class => TypeSurveySectionItemConnection::getFactory($this->context, DoctrineTypeSurveySectionItemEdge::class),
    //             DoctrineTypeSurveyAnswerSessionEdge::class => TypeSurveyAnswerSessionEdge::getFactory($this->context, DoctrineSurveyAnswerSession::class),
    //             DoctrineTypeSurveyAnswerSessionConnection::class => TypeSurveyAnswerSessionConnection::getFactory($this->context, DoctrineTypeSurveyAnswerSessionEdge::class),
    //             DoctrineTypeBuildSurveyContentInput::class => function ($sm) {
    //                 return new TypeBuildSurveyContentInput($this->context);
    //             },
    //             DoctrineTypeBuildSurveyQuestionOptionInput::class => function ($sm) {
    //                 return new TypeBuildSurveyQuestionOptionInput($this->context);
    //             },
    //             DoctrineTypeBuildSurveyQuestionInput::class => function ($sm) {
    //                 return new TypeBuildSurveyQuestionInput($this->context);
    //             },
    //             DoctrineTypeBuildSurveySectionItemInput::class => function ($sm) {
    //                 return new TypeBuildSurveySectionItemInput($this->context);
    //             },
    //             DoctrineTypeBuildSurveySectionInput::class => function ($sm) {
    //                 return new TypeBuildSurveySectionInput($this->context);
    //             },
    //             DoctrineTypeBuildSurveyTargetAudienceInput::class => function ($sm) {
    //                 return new TypeBuildSurveyTargetAudienceInput($this->context);
    //             },
    //             DoctrineTypeBuildSurveyInput::class => function ($sm) {
    //                 return new TypeBuildSurveyInput($this->context);
    //             }
    //         ],
    //         'aliases' => [
    //             TypeSurveyConfigurationValue::NAME => DoctrineTypeSurveyConfigurationValue::class,
    //             TypeSurveyAnswerQuestionInput::NAME => DoctrineTypeSurveyAnswerQuestionInput::class,
    //             TypeBuildSurveyInput::NAME => DoctrineTypeBuildSurveyInput::class,
    //             TypeSurveySectionItemType::NAME => DoctrineTypeSurveySectionItemType::class,
    //             TypeSurveyQuestionType::NAME => DoctrineTypeSurveyQuestionType::class,
    //             TypeSurveyConfigurationType::NAME => DoctrineTypeSurveyConfigurationType::class,
    //             TypeSurveyContentType::NAME => DoctrineTypeSurveyContentType::class,
    //             TypeSurveyEdge::NAME => DoctrineTypeSurveyEdge::class,
    //             TypeSurveyConnection::NAME => DoctrineTypeSurveyConnection::class,
    //             TypeSurveyTargetAudienceEdge::NAME => DoctrineTypeSurveyTargetAudienceEdge::class,
    //             TypeSurveyTargetAudienceConnection::NAME => DoctrineTypeSurveyTargetAudienceConnection::class,
    //             TypeSurveyAnswerEdge::NAME => DoctrineTypeSurveyAnswerEdge::class,
    //             TypeSurveyAnswerConnection::NAME => DoctrineTypeSurveyAnswerConnection::class,
    //             TypeSurveyConfigurationEdge::NAME => DoctrineTypeSurveyConfigurationEdge::class,
    //             TypeSurveyConfigurationConnection::NAME => DoctrineTypeSurveyConfigurationConnection::class,
    //             TypeSurveyContentEdge::NAME => DoctrineTypeSurveyContentEdge::class,
    //             TypeSurveyContentConnection::NAME => DoctrineTypeSurveyContentConnection::class,
    //             TypeSurveyQuestionEdge::NAME => DoctrineTypeSurveyQuestionEdge::class,
    //             TypeSurveyQuestionConnection::NAME => DoctrineTypeSurveyQuestionConnection::class,
    //             TypeSurveyQuestionOptionEdge::NAME => DoctrineTypeSurveyQuestionOptionEdge::class,
    //             TypeSurveyQuestionOptionConnection::NAME => DoctrineTypeSurveyQuestionOptionConnection::class,
    //             TypeSurveySectionEdge::NAME => DoctrineTypeSurveySectionEdge::class,
    //             TypeSurveySectionConnection::NAME => DoctrineTypeSurveySectionConnection::class,
    //             TypeSurveySectionItemEdge::NAME => DoctrineTypeSurveySectionItemEdge::class,
    //             TypeSurveySectionItemConnection::NAME => DoctrineTypeSurveySectionItemConnection::class,
    //             TypeSurveyAnswerSessionEdge::NAME => DoctrineTypeSurveyAnswerSessionEdge::class,
    //             TypeSurveyAnswerSessionConnection::NAME => DoctrineTypeSurveyAnswerSessionConnection::class,
    //             TypeBuildSurveyContentInput::NAME => DoctrineTypeBuildSurveyContentInput::class,
    //             TypeBuildSurveyQuestionOptionInput::NAME => DoctrineTypeBuildSurveyQuestionOptionInput::class,
    //             TypeBuildSurveyQuestionInput::NAME => DoctrineTypeBuildSurveyQuestionInput::class,
    //             TypeBuildSurveySectionItemInput::NAME => DoctrineTypeBuildSurveySectionItemInput::class,
    //             TypeBuildSurveySectionInput::NAME => DoctrineTypeBuildSurveySectionInput::class,
    //             TypeBuildSurveyTargetAudienceInput::NAME => DoctrineTypeBuildSurveyTargetAudienceInput::class,
    //             TypeBuildSurveyInput::NAME => DoctrineTypeBuildSurveyInput::class,
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
    //     $surveyConnection = $this->context->getServiceManager()->get(DoctrineTypeSurveyConnection::class);
    //     $surveyTargetAudienceConnection = $this->context->getServiceManager()->get(DoctrineTypeSurveyTargetAudienceConnection::class);
    //     $surveyAnswerConnection = $this->context->getServiceManager()->get(DoctrineTypeSurveyAnswerConnection::class);
    //     $surveyConfigurationConnection = $this->context->getServiceManager()->get(DoctrineTypeSurveyConfigurationConnection::class);
    //     $surveyContentConnection = $this->context->getServiceManager()->get(DoctrineTypeSurveyContentConnection::class);
    //     $surveyQuestionConnection = $this->context->getServiceManager()->get(DoctrineTypeSurveyQuestionConnection::class);
    //     $surveyQuestionOptionConnection = $this->context->getServiceManager()->get(DoctrineTypeSurveyQuestionOptionConnection::class);
    //     $surveySectionConnection = $this->context->getServiceManager()->get(DoctrineTypeSurveySectionConnection::class);
    //     $surveySectionItemConnection = $this->context->getServiceManager()->get(DoctrineTypeSurveySectionItemConnection::class);
    //     $surveyAnswerSessionConnection = $this->context->getServiceManager()->get(DoctrineTypeSurveyAnswerSessionConnection::class);
    //     return [
    //         'getSurveys' => ResolverFactory::forConnection(DoctrineSurvey::class, Survey::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'getSurvey' => ResolverFactory::forItem(DoctrineSurvey::class,),
    //         'getSurveyTargetAudiences' => ResolverFactory::forConnection(DoctrineSurveyTargetAudience::class, SurveyTargetAudience::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'getSurveyTargetAudience' => ResolverFactory::forItem(DoctrineSurveyTargetAudience::class,),
    //         'getSurveyAnswers' => ResolverFactory::forConnection(DoctrineSurveyAnswer::class, SurveyAnswer::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'getSurveyAnswer' => ResolverFactory::forItem(DoctrineSurveyAnswer::class,),
    //         'getSurveyConfigurations' => ResolverFactory::forConnection(DoctrineSurveyConfiguration::class, SurveyConfiguration::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'getSurveyConfiguration' => ResolverFactory::forItem(DoctrineSurveyConfiguration::class,),
    //         'getSurveyContents' => ResolverFactory::forConnection(DoctrineSurveyContent::class, SurveyContent::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'getSurveyContent' => ResolverFactory::forItem(DoctrineSurveyContent::class,),
    //         'getSurveyQuestions' => ResolverFactory::forConnection(DoctrineSurveyQuestion::class, SurveyQuestion::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'getSurveyQuestion' => ResolverFactory::forItem(DoctrineSurveyQuestion::class,),
    //         'getSurveyQuestionOptions' => ResolverFactory::forConnection(DoctrineSurveyQuestionOption::class, SurveyQuestionOption::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'getSurveyQuestionOption' => ResolverFactory::forItem(DoctrineSurveyQuestionOption::class,),
    //         'getSurveySections' => ResolverFactory::forConnection(DoctrineSurveySection::class, SurveySection::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'getSurveySection' => ResolverFactory::forItem(DoctrineSurveySection::class,),
    //         'getSurveySectionItems' => ResolverFactory::forConnection(DoctrineSurveySectionItem::class, SurveySectionItem::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'getSurveySectionItem' => ResolverFactory::forItem(DoctrineSurveySectionItem::class,),
    //         'getSurveyAnswerSessions' => ResolverFactory::forConnection(DoctrineSurveyAnswerSession::class, SurveyAnswerSession::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'getSurveyAnswerSession' => ResolverFactory::forItem(DoctrineSurveyAnswerSession::class,),
    //         'findSurveyAnswerSessionByUsernameAndPassword' => FieldFindAnswerSessionByUsernameAndPassword::get($this->context, $proxy = null),
    //         'findSurveyAnswerSessionByOwnerCode' => FieldFindAnswerSessionByOwnerCode::get($this->context, $proxy = null),
    //     ];
    // }
    // function getMutationFields(): array
    // {
    //     return [
    //         'buildSurvey' => FieldBuildSurvey::get($this->context, $this->defaultProxy),
    //         'createSurvey' => ResolverFactory::buildFieldCreate($this->context, DoctrineSurvey::class, Survey::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'updateSurvey' => ResolverFactory::buildFieldUpdate($this->context, DoctrineSurvey::class, Survey::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'deleteSurvey' => FieldDeleteSurvey::get($this->context, $this->defaultProxy),
    //         'buildSurveyTargetAudience' => FieldBuildSurveyTargetAudience::get($this->context,  $this->defaultProxy),
    //         'createSurveyTargetAudience' => ResolverFactory::buildFieldCreate($this->context, DoctrineSurveyTargetAudience::class, SurveyTargetAudience::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'updateSurveyTargetAudience' => ResolverFactory::buildFieldUpdate($this->context, DoctrineSurveyTargetAudience::class, SurveyTargetAudience::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'deleteSurveyTargetAudience' => FieldDeleteSurveyTargetAudience::get($this->context, $this->defaultProxy),
    //         'createSurveyAnswer' => ResolverFactory::buildFieldCreate($this->context, DoctrineSurveyAnswer::class, SurveyAnswer::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'updateSurveyAnswer' => ResolverFactory::buildFieldUpdate($this->context, DoctrineSurveyAnswer::class, SurveyAnswer::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'deleteSurveyAnswer' => ResolverFactory::buildFieldDelete($this->context, DoctrineSurveyAnswer::class, SurveyAnswer::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'createSurveyConfiguration' => ResolverFactory::buildFieldCreate($this->context, DoctrineSurveyConfiguration::class, SurveyConfiguration::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'updateSurveyConfiguration' => ResolverFactory::buildFieldUpdate($this->context, DoctrineSurveyConfiguration::class, SurveyConfiguration::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'deleteSurveyConfiguration' => ResolverFactory::buildFieldDelete($this->context, DoctrineSurveyConfiguration::class, SurveyConfiguration::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'createSurveyContent' => ResolverFactory::buildFieldCreate($this->context, DoctrineSurveyContent::class, SurveyContent::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'updateSurveyContent' => ResolverFactory::buildFieldUpdate($this->context, DoctrineSurveyContent::class, SurveyContent::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'deleteSurveyContent' => FieldDeleteSurveyContent::get($this->context, $this->defaultProxy),
    //         'buildSurveyQuestion' => FieldBuildSurveyQuestion::get($this->context, $this->defaultProxy),
    //         'createSurveyQuestion' => ResolverFactory::buildFieldCreate($this->context, DoctrineSurveyQuestion::class, SurveyQuestion::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'updateSurveyQuestion' => ResolverFactory::buildFieldUpdate($this->context, DoctrineSurveyQuestion::class, SurveyQuestion::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'deleteSurveyQuestion' => FieldDeleteSurveyQuestion::get($this->context,  $this->defaultProxy),
    //         'createSurveyQuestionOption' => ResolverFactory::buildFieldCreate($this->context, DoctrineSurveyQuestionOption::class, SurveyQuestionOption::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'updateSurveyQuestionOption' => ResolverFactory::buildFieldUpdate($this->context, DoctrineSurveyQuestionOption::class, SurveyQuestionOption::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'deleteSurveyQuestionOption' => FieldDeleteSurveyQuestionOption::get($this->context, $this->defaultProxy),
    //         'buildSurveySection' => FieldBuildSurveySection::get($this->context, $this->defaultProxy),
    //         'createSurveySection' => ResolverFactory::buildFieldCreate($this->context, DoctrineSurveySection::class, SurveySection::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'updateSurveySection' => ResolverFactory::buildFieldUpdate($this->context, DoctrineSurveySection::class, SurveySection::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'deleteSurveySection' => FieldDeleteSurveySection::get($this->context,  $this->defaultProxy),
    //         'buildSurveySectionItem' => FieldBuildSurveySectionItem::get($this->context, $this->defaultProxy),
    //         'createSurveySectionItem' => ResolverFactory::buildFieldCreate($this->context, DoctrineSurveySectionItem::class, SurveySectionItem::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'updateSurveySectionItem' => ResolverFactory::buildFieldUpdate($this->context, DoctrineSurveySectionItem::class, SurveySectionItem::RELATIONS_MANY_TO_ONE, $this->defaultProxy),
    //         'deleteSurveySectionItem' => FieldDeleteSurveySectionItem::get($this->context,  $this->defaultProxy),
    //         'createSurveyAnswerSession' => FieldCreateAnswerSession::get($this->context, $proxy = null),
    //         'updateSurveyAnswerSession' => FieldUpdateAnswerSession::get($this->context, $proxy = null),
    //         'deleteSurveyAnswerSession' => FieldDeleteSurveyAnswerSession::get($this->context, $this->defaultProxy),
    //     ];
    // }
}
