<?php

declare(strict_types=1);

namespace GPDSurvey\Graphql\Types;

use GPDSurvey\Library\ISurveyContent;
use GraphQL\Type\Definition\EnumType;

class TypeSurveyContentType extends EnumType
{

    const NAME = "SurveyContentType";
    public function __construct()
    {
        $config = [
            'name' => static::NAME,
            'values' => [
                ISurveyContent::SURVEY_CONTENT_TYPE_DIVIDER,
                ISurveyContent::SURVEY_CONTENT_TYPE_HTML,
                ISurveyContent::SURVEY_CONTENT_TYPE_IMAGE,
                ISurveyContent::SURVEY_CONTENT_TYPE_VIDEO,
                ISurveyContent::SURVEY_CONTENT_TYPE_AUDIO,
                ISurveyContent::SURVEY_CONTENT_TYPE_ANY,
            ],
        ];

        parent::__construct($config);
    }
}
