<?php

declare(strict_types=1);

namespace GPDSurvey\Graphql\Types;

use GPDSurvey\Library\ISurveyConfiguration;
use GraphQL\Type\Definition\EnumType;

class TypeSurveyConfigurationType extends EnumType
{

    public function __construct()
    {
        $config = [
            'name' => 'SurveyConfigurationType',
            'values' => [
                ISurveyConfiguration::SURVEY_CONFIGURATION_TYPE_ANSWER_SCORE,
                ISurveyConfiguration::SURVEY_CONFIGURATION_TYPE_CONDITION,
                ISurveyConfiguration::SURVEY_CONFIGURATION_TYPE_PRESENTATION,
                ISurveyConfiguration::SURVEY_CONFIGURATION_TYPE_VALIDATORS,
            ],
        ];

        parent::__construct($config);
    }
}
