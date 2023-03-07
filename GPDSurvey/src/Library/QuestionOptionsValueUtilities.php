<?php

namespace GPDSurvey\Library;


class QuestionOptionsValueUtilities
{


    public static function getFormatedAnswer(array $question, array $options, ?string $answer): ?string
    {
        if (empty($answer)) {
            return $answer;
        }
        $type = $question["type"];
        $formatedAnswer = $answer;
        switch ($type) {
            case ISurveyQuestion::SURVEY_QUESTION_TYPE_CHECKBOX_LIST:
            case ISurveyQuestion::SURVEY_QUESTION_TYPE_RADIO_LIST:
                $formatedAnswer = static::formatQuestionOption($options, $answer);
                break;
            case ISurveyQuestion::SURVEY_QUESTION_TYPE_IMAGE:
            case ISurveyQuestion::SURVEY_QUESTION_TYPE_FILE:
                $formatedAnswer = static::formatQuestionFile($answer);
                break;
        }

        // @TODO Agregar formato para fechas si es que es necesario
        return $formatedAnswer;
    }

    protected static function formatQuestionOption(array $options, string $answer): string
    {
        $formatedValue = $options[$answer] ?? $answer;
        return $formatedValue;
    }

    protected static function formatQuestionFile(string $answer): string
    {
        if (!empty($answer)) {
            $url = $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] . DIRECTORY_SEPARATOR . "uploads" . DIRECTORY_SEPARATOR . $answer;
            return  $url;
        } else {
            return "";
        }
    }
}
