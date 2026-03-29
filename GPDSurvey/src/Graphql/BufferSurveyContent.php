<?php

namespace GPDSurvey\Graphql;

use GPDCore\DataLoaders\EntityDataLoader;
use GPDSurvey\Entities\SurveyContent;

class BufferSurveyContent
{

    private static $instance;

    public static function getInstance(): EntityDataLoader
    {

        if (static::$instance === null) {
            static::$instance = new EntityDataLoader(SurveyContent::class, SurveyContent::RELATIONS_MANY_TO_ONE);
        }
        return static::$instance;
    }
}
