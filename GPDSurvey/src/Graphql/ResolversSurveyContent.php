<?php

declare(strict_types=1);

namespace GPDSurvey\Graphql;

use GPDCore\Library\EntityBuffer;
use GPDCore\Library\ResolverFactory;
use GPDSurvey\Entities\SurveyConfiguration;
use GPDSurvey\Graphql\BufferSurveyConfiguration;

class ResolversSurveyContent
{

    public static function getPresentationResolver(?callable $proxy): callable
    {
        $presentationsBuffer = new EntityBuffer(SurveyConfiguration::class, SurveyConfiguration::RELATIONS_MANY_TO_ONE);
        $resolver = ResolverFactory::createEntityResolver($presentationsBuffer, 'presentation');
        return is_callable($proxy) ? $proxy($resolver) : $resolver;
    }
}
