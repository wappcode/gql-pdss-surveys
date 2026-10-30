<?php

declare(strict_types=1);

namespace GPDSurvey\Graphql;

use GPDSurvey\Graphql\BufferSurvey;
use GPDCore\Library\EntityBuffer;
use GPDSurvey\Infrastructure\Doctrine\Entities\SurveyContent;
use GPDSurvey\Infrastructure\Doctrine\Entities\SurveySection;
use GPDCore\Library\ResolverFactory;
use GPDSurvey\Infrastructure\Doctrine\Entities\Survey;
use GPDSurvey\Infrastructure\Doctrine\Entities\SurveySectionItem;
use GPDSurvey\Graphql\BufferSurveyContent;
use GPDSurvey\Infrastructure\Doctrine\Entities\SurveyConfiguration;
use GPDSurvey\Graphql\BufferSurveyConfiguration;

class ResolversSurveySection
{

    public static function getSurveyResolver(?callable $proxy): callable
    {
        $entityBuffer = new EntityBuffer(Survey::class, Survey::RELATIONS_MANY_TO_ONE);
        $resolver = ResolverFactory::createEntityResolver($entityBuffer, 'survey');
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
    public static function getItemsResolver(?callable $proxy): callable
    {
        $resolver = ResolverFactory::createCollectionResolver(SurveySection::class, 'items', SurveySectionItem::RELATIONS_MANY_TO_ONE);
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
}
