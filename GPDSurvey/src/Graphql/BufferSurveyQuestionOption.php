<?php

namespace GPDSurvey\Graphql;

use GPDSurvey\Infrastructure\Doctrine\Entities\Survey;
use GPDCore\Library\EntityBuffer;
use GPDSurvey\Infrastructure\Doctrine\Entities\SurveyQuestionOption;

class BufferSurveyQuestionOption
{

    private static $instance;

    public static function getInstance(): EntityBuffer
    {

        if (static::$instance === null) {
            static::$instance = new EntityBuffer(SurveyQuestionOption::class, SurveyQuestionOption::RELATIONS_MANY_TO_ONE);
        }
        return static::$instance;
    }
}
