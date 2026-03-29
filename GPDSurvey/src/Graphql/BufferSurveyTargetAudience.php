<?php

namespace GPDSurvey\Graphql;

use GPDCore\DataLoaders\EntityDataLoader;
use GPDSurvey\Entities\SurveyTargetAudience;

class BufferSurveyTargetAudience
{

    private static $instance;

    public static function getInstance(): EntityDataLoader
    {

        if (static::$instance === null) {
            static::$instance = new EntityDataLoader(SurveyTargetAudience::class, SurveyTargetAudience::RELATIONS_MANY_TO_ONE);
        }
        return static::$instance;
    }
}
