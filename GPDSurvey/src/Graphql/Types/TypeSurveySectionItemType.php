<?php

declare(strict_types=1);

namespace GPDSurvey\Graphql\Types;

use GraphQL\Type\Definition\EnumType;
use GPDSurvey\Entities\SurveySectionItem;

class TypeSurveySectionItemType extends EnumType
{

    public function __construct()
    {
        $config = [
            'name' => 'SurveySectionItemType',
            'values' => [
                SurveySectionItem::SURVEY_QUESTION_ITEM_CONTENT,
                SurveySectionItem::SURVEY_QUESTION_ITEM_QUESTION,
            ],
        ];

        parent::__construct($config);
    }
}
