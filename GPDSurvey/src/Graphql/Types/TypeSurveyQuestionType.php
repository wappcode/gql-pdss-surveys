<?php

declare(strict_types=1);

namespace GPDSurvey\Graphql\Types;

use GPDSurvey\Entities\SurveyQuestion;
use GraphQL\Type\Definition\EnumType;

class TypeSurveyQuestionType extends EnumType
{

    public function __construct()
    {
        $config = [
            'name' => 'SurveyQuestionType',
            'values' => [
                SurveyQuestion::SURVEY_QUESTION_TYPE_CHECKBOX_LIST,
                SurveyQuestion::SURVEY_QUESTION_TYPE_DATE,
                SurveyQuestion::SURVEY_QUESTION_TYPE_DATE_RANGE,
                SurveyQuestion::SURVEY_QUESTION_TYPE_DATETIME,
                SurveyQuestion::SURVEY_QUESTION_TYPE_EMAIL,
                SurveyQuestion::SURVEY_QUESTION_TYPE_FILE,
                SurveyQuestion::SURVEY_QUESTION_TYPE_IMAGE,
                SurveyQuestion::SURVEY_QUESTION_TYPE_NUMBER,
                SurveyQuestion::SURVEY_QUESTION_TYPE_NUMBER_LIST,
                SurveyQuestion::SURVEY_QUESTION_TYPE_ONE_LINE_TEXT,
                SurveyQuestion::SURVEY_QUESTION_TYPE_PHONE,
                SurveyQuestion::SURVEY_QUESTION_TYPE_RADIO_LIST,
                SurveyQuestion::SURVEY_QUESTION_TYPE_SHORT_TEXT,
            ],
        ];

        parent::__construct($config);
    }
}
