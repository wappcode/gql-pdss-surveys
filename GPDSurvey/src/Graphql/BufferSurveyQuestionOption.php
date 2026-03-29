<?php

namespace GPDSurvey\Graphql;

use GPDSurvey\Entities\Survey;
use GPDCore\DataLoaders\EntityDataLoader;
use GPDSurvey\Entities\SurveyQuestionOption;

class BufferSurveyQuestionOption
{

    private static $instance;

    public static function getInstance(): EntityDataLoader
    {

        if (static::$instance === null) {
            static::$instance = new EntityDataLoader(SurveyQuestionOption::class, SurveyQuestionOption::RELATIONS_MANY_TO_ONE);
        }
        return static::$instance;
    }
}
