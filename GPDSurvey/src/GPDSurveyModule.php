<?php

namespace GPDSurvey;

use GPDCore\Core\AbstractModule;
use GPDSurvey\Entities\Survey;
use GPDCore\Graphql\ResolverFactory;
use GPDSurvey\Entities\SurveyAnswer;
use GPDSurvey\Entities\SurveyContent;
use GPDSurvey\Entities\SurveySection;
use GPDSurvey\Entities\SurveyQuestion;
use GPDSurvey\Graphql\ResolversSurvey;
use GPDSurvey\Graphql\FieldBuildSurvey;
use GPDSurvey\Entities\SurveySectionItem;
use GPDSurvey\Entities\SurveyAnswerSession;
use GPDSurvey\Entities\SurveyConfiguration;
use GPDSurvey\Entities\SurveyQuestionOption;
use GPDSurvey\Entities\SurveyTargetAudience;
use GPDSurvey\Graphql\FieldBuildSurveyQuestion;
use GPDSurvey\Graphql\FieldBuildSurveySection;
use GPDSurvey\Graphql\FieldBuildSurveySectionItem;
use GPDSurvey\Graphql\FieldBuildSurveyTargetAudience;
use GPDSurvey\Graphql\ResolversSurveyAnswer;
use GPDSurvey\Graphql\ResolversSurveyContent;
use GPDSurvey\Graphql\ResolversSurveySection;
use GPDSurvey\Graphql\ResolversSurveyQuestion;
use GPDSurvey\Graphql\FieldCreateAnswerSession;
use GPDSurvey\Graphql\FieldUpdateAnswerSession;
use GPDSurvey\Graphql\ResolversSurveySectionItem;
use GPDSurvey\Graphql\Types\TypeBuildSurveyInput;
use GPDSurvey\Graphql\Types\TypeSurveyContentType;
use GPDSurvey\Graphql\ResolversSurveyAnswerSession;
use GPDSurvey\Graphql\Types\TypeSurveyQuestionType;
use GPDSurvey\Graphql\ResolversSurveyQuestionOption;
use GPDSurvey\Graphql\ResolversSurveyTargetAudience;
use GPDSurvey\Graphql\Types\TypeSurveySectionItemType;
use GPDSurvey\Graphql\FieldFindAnswerSessionByOwnerCode;
use GPDSurvey\Graphql\Types\TypeSurveyConfigurationType;
use GPDSurvey\Graphql\Types\TypeSurveyConfigurationValue;
use GPDSurvey\Graphql\Types\TypeSurveyAnswerQuestionInput;
use GPDSurvey\Graphql\FieldFindAnswerSessionByUsernameAndPassword;

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
    function getRoutes(): array
    {
        return [];
    }
    function getMiddlewares(): array
    {
        return [];
    }
    function getTypes(): array
    {
        return [];
    }
    function getSchema(): string
    {
        return file_get_contents(__DIR__ . '/../config/survey-schema.graphql');
    }
    function getServices(): array
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
            'factories' => [],
            'aliases' => []
        ];
    }
    function getResolvers(): array
    {
        $queries = $this->getQueryFields();
        $mutations = $this->getMutationFields();

        $resolvers = [
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
            'SurveyQuestion::hint' => ResolversSurveyQuestion::getHintResolver(null),
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
        return array_merge($resolvers, $queries, $mutations);
    }
    //TODO: Cambiar el nombre de los campos de query agregando el prefijo get
    function getQueryFields(): array
    {
        $context = $this->getAppContext();
        return [
            'Query::getSurveys' => ResolverFactory::forConnection(Survey::class),
            'Query::getSurvey' => ResolverFactory::forItem(Survey::class),
            'Query::getSurveyTargetAudiences' => ResolverFactory::forConnection(SurveyTargetAudience::class),
            'Query::getSurveyTargetAudience' => ResolverFactory::forItem(SurveyTargetAudience::class),
            'Query::getSurveyAnswers' => ResolverFactory::forConnection(SurveyAnswer::class),
            'Query::getSurveyAnswer' => ResolverFactory::forItem(SurveyAnswer::class),
            'Query::getSurveyConfigurations' => ResolverFactory::forConnection(SurveyConfiguration::class),
            'Query::getSurveyConfiguration' => ResolverFactory::forItem(SurveyConfiguration::class),
            'Query::getSurveyContents' => ResolverFactory::forConnection(SurveyContent::class),
            'Query::getSurveyContent' => ResolverFactory::forItem(SurveyContent::class),
            'Query::getSurveyQuestions' => ResolverFactory::forConnection(SurveyQuestion::class),
            'Query::getSurveyQuestion' => ResolverFactory::forItem(SurveyQuestion::class),
            'Query::getSurveyQuestionOptions' => ResolverFactory::forConnection(SurveyQuestionOption::class),
            'Query::getSurveyQuestionOption' => ResolverFactory::forItem(SurveyQuestionOption::class),
            'Query::getSurveySections' => ResolverFactory::forConnection(SurveySection::class),
            'Query::getSurveySection' => ResolverFactory::forItem(SurveySection::class),
            'Query::getSurveySectionItems' => ResolverFactory::forConnection(SurveySectionItem::class),
            'Query::getSurveySectionItem' => ResolverFactory::forItem(SurveySectionItem::class),
            'Query::getSurveyAnswerSessions' => ResolverFactory::forConnection(SurveyAnswerSession::class),
            'Query::getSurveyAnswerSession' => ResolverFactory::forItem(SurveyAnswerSession::class),
            'Query::findSurveyAnswerSessionByUsernameAndPassword' => FieldFindAnswerSessionByUsernameAndPassword::createReslove(),
            'Query::findSurveyAnswerSessionByOwnerCode' => FieldFindAnswerSessionByOwnerCode::createReslove(),
        ];
    }
    function getMutationFields(): array
    {
        return [
            'Mutation::buildSurvey' => FieldBuildSurvey::createResolve(),
            'Mutation::createSurvey' => ResolverFactory::forCreate(Survey::class),
            'Mutation::updateSurvey' => ResolverFactory::forUpdate(Survey::class),
            'Mutation::deleteSurvey' => ResolverFactory::forDelete(Survey::class),
            'Mutation::buildSurveyTargetAudience' => FieldBuildSurveyTargetAudience::createResolve(),
            'Mutation::createSurveyTargetAudience' => ResolverFactory::forCreate(SurveyTargetAudience::class),
            'Mutation::updateSurveyTargetAudience' => ResolverFactory::forUpdate(SurveyTargetAudience::class),
            'Mutation::deleteSurveyTargetAudience' => ResolverFactory::forDelete(SurveyTargetAudience::class),
            'Mutation::createSurveyAnswer' => ResolverFactory::forCreate(SurveyAnswer::class),
            'Mutation::updateSurveyAnswer' => ResolverFactory::forUpdate(SurveyAnswer::class),
            'Mutation::deleteSurveyAnswer' => ResolverFactory::forDelete(SurveyAnswer::class),
            'Mutation::createSurveyConfiguration' => ResolverFactory::forCreate(SurveyConfiguration::class),
            'Mutation::updateSurveyConfiguration' => ResolverFactory::forUpdate(SurveyConfiguration::class),
            'Mutation::deleteSurveyConfiguration' => ResolverFactory::forDelete(SurveyConfiguration::class),
            'Mutation::createSurveyContent' => ResolverFactory::forCreate(SurveyContent::class),
            'Mutation::updateSurveyContent' => ResolverFactory::forUpdate(SurveyContent::class),
            'Mutation::deleteSurveyContent' => ResolverFactory::forDelete(SurveyContent::class),
            'Mutation::buildSurveyQuestion' => FieldBuildSurveyQuestion::createResolve(),
            'Mutation::createSurveyQuestion' => ResolverFactory::forCreate(SurveyQuestion::class),
            'Mutation::updateSurveyQuestion' => ResolverFactory::forUpdate(SurveyQuestion::class),
            'Mutation::deleteSurveyQuestion' => ResolverFactory::forDelete(SurveyQuestion::class),
            'Mutation::createSurveyQuestionOption' => ResolverFactory::forCreate(SurveyQuestionOption::class),
            'Mutation::updateSurveyQuestionOption' => ResolverFactory::forUpdate(SurveyQuestionOption::class),
            'Mutation::deleteSurveyQuestionOption' => ResolverFactory::forDelete(SurveyQuestionOption::class),
            'Mutation::buildSurveySection' => FieldBuildSurveySection::createResolve(),
            'Mutation::createSurveySection' => ResolverFactory::forCreate(SurveySection::class),
            'Mutation::updateSurveySection' => ResolverFactory::forUpdate(SurveySection::class),
            'Mutation::deleteSurveySection' => ResolverFactory::forDelete(SurveySection::class),
            'Mutation::buildSurveySectionItem' => FieldBuildSurveySectionItem::createResolve(),
            'Mutation::createSurveySectionItem' => ResolverFactory::forCreate(SurveySectionItem::class),
            'Mutation::updateSurveySectionItem' => ResolverFactory::forUpdate(SurveySectionItem::class),
            'Mutation::deleteSurveySectionItem' => ResolverFactory::forDelete(SurveySectionItem::class),
            'Mutation::createSurveyAnswerSession' => FieldCreateAnswerSession::createResolve(),
            'Mutation::updateSurveyAnswerSession' => FieldUpdateAnswerSession::createResolve(),
            'Mutation::deleteSurveyAnswerSession' => ResolverFactory::forDelete(SurveyAnswerSession::class),
        ];
    }
}
