<?php

declare(strict_types=1);

namespace GPDSurvey\Graphql\Types;

use GPDSurvey\Entities\SurveyContent;
use GraphQL\Type\Definition\EnumType;

class TypeSurveyContentType extends EnumType
{

    public function __construct()
    {
        $config = [
            'name' => 'SurveyContentType',
            'values' => [
                SurveyContent::SURVEY_CONTENT_TYPE_DIVIDER,
                SurveyContent::SURVEY_CONTENT_TYPE_HTML,
                SurveyContent::SURVEY_CONTENT_TYPE_IMAGE,
                SurveyContent::SURVEY_CONTENT_TYPE_VIDEO,
            ],
        ];

        parent::__construct($config);
    }
}
