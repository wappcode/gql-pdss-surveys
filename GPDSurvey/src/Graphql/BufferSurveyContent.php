<?php

namespace GPDSurvey\Graphql;

use GPDCore\Library\EntityBuffer;
use GPDSurvey\Entities\SurveyContent;

class BufferSurveyContent
{

    private static $instance;

    public static function getInstance(): EntityBuffer
    {

        if (static::$instance === null) {
            static::$instance = new EntityBuffer(SurveyContent::class, SurveyContent::RELATIONS_MANY_TO_ONE);
        }
        return static::$instance;
    }
}
