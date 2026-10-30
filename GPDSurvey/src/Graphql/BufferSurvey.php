<?php

namespace GPDSurvey\Graphql;

use GPDCore\Library\EntityBuffer;
use GPDSurvey\Infrastructure\Doctrine\Entities\Survey;

class BufferSurvey
{

    private static $instance;

    public static function getInstance(): EntityBuffer
    {

        if (static::$instance === null) {
            static::$instance = new EntityBuffer(Survey::class, Survey::RELATIONS_MANY_TO_ONE);
        }
        return static::$instance;
    }
}
