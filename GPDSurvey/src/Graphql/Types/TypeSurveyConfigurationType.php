<?php

declare(strict_types=1);

namespace GPDSurvey\Graphql\Types;

use GraphQL\Type\Definition\EnumType;
use GPDSurvey\Entities\SurveyConfiguration;

class TypeSurveyConfigurationType extends EnumType
{

    public function __construct()
    {
        $config = [
            'name' => 'SurveyConfigurationType',
            'values' => [
                SurveyConfiguration::SURVEY_CONFIGURATION_TYPE_ANSWER_SCORE,
                SurveyConfiguration::SURVEY_CONFIGURATION_TYPE_CONDITION,
                SurveyConfiguration::SURVEY_CONFIGURATION_TYPE_PRESENTATION,
                SurveyConfiguration::SURVEY_CONFIGURATION_TYPE_VALIDATORS,
            ],
        ];

        parent::__construct($config);
    }
}
