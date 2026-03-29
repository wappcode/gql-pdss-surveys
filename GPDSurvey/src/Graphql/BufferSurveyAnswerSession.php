<?php

namespace GPDSurvey\Graphql;

use GPDCore\DataLoaders\EntityDataLoader;
use GPDSurvey\Entities\SurveyAnswerSession;

class BufferSurveyAnswerSession
{

    private static $instance;

    public static function getInstance(): EntityDataLoader
    {

        if (static::$instance === null) {
            static::$instance = new EntityDataLoader(SurveyAnswerSession::class, SurveyAnswerSession::RELATIONS_MANY_TO_ONE);
        }
        return static::$instance;
    }
}
