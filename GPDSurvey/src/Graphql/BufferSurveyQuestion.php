<?php

namespace GPDSurvey\Graphql;

use GPDCore\Library\EntityBuffer;
use GPDSurvey\Entities\SurveyQuestion;

class BufferSurveyQuestion
{

    private static $instance;

    public static function getInstance(): EntityBuffer
    {

        if (static::$instance === null) {
            static::$instance = new EntityBuffer(SurveyQuestion::class, SurveyQuestion::RELATIONS_MANY_TO_ONE);
        }
        return static::$instance;
    }
}
