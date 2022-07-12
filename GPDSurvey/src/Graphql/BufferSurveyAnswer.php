<?php

namespace GPDSurvey\Graphql;

use GPDCore\Library\EntityBuffer;
use GPDSurvey\Entities\SurveyAnswer;

class BufferSurveyAnswer
{

    private static $instance;

    public static function getInstance(): EntityBuffer
    {

        if (static::$instance === null) {
            static::$instance = new EntityBuffer(SurveyAnswer::class, SurveyAnswer::RELATIONS_MANY_TO_ONE);
        }
        return static::$instance;
    }
}
