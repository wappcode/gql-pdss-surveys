<?php

declare(strict_types=1);

namespace GPDSurvey\Graphql\Types;

use GPDSurvey\Library\ISurveyConfiguration;
use GraphQL\Type\Definition\EnumType;

class TypeSurveyConfigurationType extends EnumType
{
    const NAME = "SurveyConfigurationType";

    public function __construct()
    {
        $config = [
            'name' => static::NAME,
            'values' => [
                ISurveyConfiguration::SURVEY_CONFIGURATION_TYPE_ANSWER_SCORE,
                ISurveyConfiguration::SURVEY_CONFIGURATION_TYPE_CONDITION,
                ISurveyConfiguration::SURVEY_CONFIGURATION_TYPE_PRESENTATION,
                ISurveyConfiguration::SURVEY_CONFIGURATION_TYPE_VALIDATOR,
            ],
        ];

        parent::__construct($config);
    }
}
