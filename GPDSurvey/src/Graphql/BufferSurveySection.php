<?php

namespace GPDSurvey\Graphql;

use GPDCore\DataLoaders\EntityDataLoader;
use GPDSurvey\Entities\SurveySection;

class BufferSurveySection
{

    private static $instance;

    public static function getInstance(): EntityDataLoader
    {

        if (static::$instance === null) {
            static::$instance = new EntityDataLoader(SurveySection::class, SurveySection::RELATIONS_MANY_TO_ONE);
        }
        return static::$instance;
    }
}
