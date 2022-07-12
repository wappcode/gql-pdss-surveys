<?php

namespace GPDSurvey\Graphql;

use GPDCore\Library\EntityBuffer;
use GPDSurvey\Entities\SurveyTargetAudience;

class BufferSurveyTargetAudience
{

    private static $instance;

    public static function getInstance(): EntityBuffer
    {

        if (static::$instance === null) {
            static::$instance = new EntityBuffer(SurveyTargetAudience::class, SurveyTargetAudience::RELATIONS_MANY_TO_ONE);
        }
        return static::$instance;
    }
}
