<?php

declare(strict_types=1);

namespace GPDSurvey\Graphql\Types;

use GPDSurvey\Library\ISurveyContent;
use GraphQL\Type\Definition\EnumType;

class TypeSurveyContentType extends EnumType
{

    public function __construct()
    {
        $config = [
            'name' => 'SurveyContentType',
            'values' => [
                ISurveyContent::SURVEY_CONTENT_TYPE_DIVIDER,
                ISurveyContent::SURVEY_CONTENT_TYPE_HTML,
                ISurveyContent::SURVEY_CONTENT_TYPE_IMAGE,
                ISurveyContent::SURVEY_CONTENT_TYPE_VIDEO,
            ],
        ];

        parent::__construct($config);
    }
}
