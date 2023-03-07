<?php

declare(strict_types=1);

namespace GPDSurvey\Graphql\Types;

use GPDSurvey\Library\ISurveyQuestion;
use GraphQL\Type\Definition\EnumType;

class TypeSurveyQuestionType extends EnumType
{

    public function __construct()
    {
        $config = [
            'name' => 'SurveyQuestionType',
            'values' => [
                ISurveyQuestion::SURVEY_QUESTION_TYPE_CHECKBOX_LIST,
                ISurveyQuestion::SURVEY_QUESTION_TYPE_DATE,
                ISurveyQuestion::SURVEY_QUESTION_TYPE_DATE_RANGE,
                ISurveyQuestion::SURVEY_QUESTION_TYPE_DATETIME,
                ISurveyQuestion::SURVEY_QUESTION_TYPE_EMAIL,
                ISurveyQuestion::SURVEY_QUESTION_TYPE_FILE,
                ISurveyQuestion::SURVEY_QUESTION_TYPE_IMAGE,
                ISurveyQuestion::SURVEY_QUESTION_TYPE_NUMBER,
                ISurveyQuestion::SURVEY_QUESTION_TYPE_NUMBER_LIST,
                ISurveyQuestion::SURVEY_QUESTION_TYPE_ONE_LINE_TEXT,
                ISurveyQuestion::SURVEY_QUESTION_TYPE_PHONE,
                ISurveyQuestion::SURVEY_QUESTION_TYPE_RADIO_LIST,
                ISurveyQuestion::SURVEY_QUESTION_TYPE_SHORT_TEXT,
            ],
        ];

        parent::__construct($config);
    }
}
