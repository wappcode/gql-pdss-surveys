<?php

namespace GPDSurvey\Graphql;

use GPDCore\DataLoaders\EntityDataLoader;
use GPDSurvey\Entities\SurveyConfiguration;

class BufferSurveyConfiguration
{

    private static $instance;

    public static function getInstance(): EntityDataLoader
    {

        if (static::$instance === null) {
            static::$instance = new EntityDataLoader(SurveyConfiguration::class, SurveyConfiguration::RELATIONS_MANY_TO_ONE);
        }
        return static::$instance;
    }
}
