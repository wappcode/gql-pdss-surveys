<?php

namespace GPDSurvey\Graphql;

use GPDSurvey\Entities\Survey;
use GPDCore\DataLoaders\EntityDataLoader;
use GPDSurvey\Entities\SurveySectionItem;

class BufferSurveySectionItem
{

    private static $instance;

    public static function getInstance(): EntityDataLoader
    {

        if (static::$instance === null) {
            static::$instance = new EntityDataLoader(SurveySectionItem::class, SurveySectionItem::RELATIONS_MANY_TO_ONE);
        }
        return static::$instance;
    }
}
