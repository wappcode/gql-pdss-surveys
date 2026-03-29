<?php

namespace GPDSurvey\Graphql;

use GPDCore\DataLoaders\EntityDataLoader;
use GPDSurvey\Entities\Survey;

class BufferSurvey
{

    private static $instance;

    public static function getInstance(): EntityDataLoader
    {

        if (static::$instance === null) {
            static::$instance = new EntityDataLoader(Survey::class, Survey::RELATIONS_MANY_TO_ONE);
        }
        return static::$instance;
    }
}
