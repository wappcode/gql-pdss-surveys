<?php

namespace GPDSurvey\Graphql;

use GPDCore\DataLoaders\EntityDataLoader;
use GPDSurvey\Entities\SurveyAnswer;

class BufferSurveyAnswer
{

    private static $instance;

    public static function getInstance(): EntityDataLoader
    {

        if (static::$instance === null) {
            static::$instance = new EntityDataLoader(SurveyAnswer::class, SurveyAnswer::RELATIONS_MANY_TO_ONE);
        }
        return static::$instance;
    }
}
