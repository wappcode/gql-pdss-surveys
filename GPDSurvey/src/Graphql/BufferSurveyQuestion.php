<?php

namespace GPDSurvey\Graphql;

use GPDCore\DataLoaders\EntityDataLoader;
use GPDSurvey\Entities\SurveyQuestion;

class BufferSurveyQuestion
{

    private static $instance;

    public static function getInstance(): EntityDataLoader
    {

        if (static::$instance === null) {
            static::$instance = new EntityDataLoader(SurveyQuestion::class, SurveyQuestion::RELATIONS_MANY_TO_ONE);
        }
        return static::$instance;
    }
}
