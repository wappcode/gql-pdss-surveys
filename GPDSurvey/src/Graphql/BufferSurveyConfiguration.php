<?php

namespace GPDSurvey\Graphql;

use GPDCore\Library\EntityBuffer;
use GPDSurvey\Entities\SurveyConfiguration;

class BufferSurveyConfiguration
{

    private static $instance;

    public static function getInstance(): EntityBuffer
    {

        if (static::$instance === null) {
            static::$instance = new EntityBuffer(SurveyConfiguration::class, SurveyConfiguration::RELATIONS_MANY_TO_ONE);
        }
        return static::$instance;
    }
}
