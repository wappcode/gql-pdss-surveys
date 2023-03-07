<?php

namespace GPDSurvey\Library;

interface ISurveyQuestion
{
    const SURVEY_QUESTION_TYPE_SHORT_TEXT = 'SHORT_TEXT';
    const SURVEY_QUESTION_TYPE_ONE_LINE_TEXT = 'ONE_LINE_TEXT';
    const SURVEY_QUESTION_TYPE_RADIO_LIST = 'RADIO_LIST';
    const SURVEY_QUESTION_TYPE_NUMBER_LIST = 'NUMBER_LIST';
    const SURVEY_QUESTION_TYPE_CHECKBOX_LIST = 'CHECKBOX_LIST';
    const SURVEY_QUESTION_TYPE_EMAIL = 'EMAIL';
    const SURVEY_QUESTION_TYPE_PHONE = 'PHONE';
    const SURVEY_QUESTION_TYPE_NUMBER = 'NUMBER';
    const SURVEY_QUESTION_TYPE_IMAGE = 'IMAGE';
    const SURVEY_QUESTION_TYPE_FILE = 'FILE';
    const SURVEY_QUESTION_TYPE_DATE = 'DATE';
    const SURVEY_QUESTION_TYPE_DATE_RANGE = 'DATE_RANGE';
    const SURVEY_QUESTION_TYPE_DATETIME = 'DATETIME';
}