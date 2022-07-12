<?php

namespace GPDSurvey\Graphql;

use GPDCore\Library\EntityBuffer;
use GPDSurvey\Entities\SurveyAnswerSession;

class BufferSurveyAnswerSession
{

    private static $instance;

    public static function getInstance(): EntityBuffer
    {

        if (static::$instance === null) {
            static::$instance = new EntityBuffer(SurveyAnswerSession::class, SurveyAnswerSession::RELATIONS_MANY_TO_ONE);
        }
        return static::$instance;
    }
}
