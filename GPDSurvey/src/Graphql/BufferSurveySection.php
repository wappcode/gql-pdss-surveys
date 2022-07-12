<?php

namespace GPDSurvey\Graphql;

use GPDCore\Library\EntityBuffer;
use GPDSurvey\Entities\SurveySection;

class BufferSurveySection
{

    private static $instance;

    public static function getInstance(): EntityBuffer
    {

        if (static::$instance === null) {
            static::$instance = new EntityBuffer(SurveySection::class, SurveySection::RELATIONS_MANY_TO_ONE);
        }
        return static::$instance;
    }
}
