<?php

namespace GPDSurvey\Library;

use GPDSurvey\Entities\SurveyQuestion;

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
            case SurveyQuestion::SURVEY_QUESTION_TYPE_CHECKBOX_LIST:
            case SurveyQuestion::SURVEY_QUESTION_TYPE_RADIO_LIST:
                $formatedAnswer = static::formatQuestionOption($options, $answer);
                break;
            case SurveyQuestion::SURVEY_QUESTION_TYPE_IMAGE:
            case SurveyQuestion::SURVEY_QUESTION_TYPE_FILE:
                $formatedAnswer = static::formatQuestionFile($answer);
                break;
            case SurveyQuestion::SURVEY_QUESTION_TYPE_TSHIRT:
                $formatedAnswer = static::formatQuestionTshit($answer);
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
    protected static function formatQuestionTshit(string $answer): string
    {
        $formatedAnswer = $answer;
        switch ($answer) {
            case 'XS':
                $formatedAnswer = "Extra chica";
                break;
            case 'S':
                $formatedAnswer = "Chica";
                break;
            case 'M':
                $formatedAnswer = "Mediana";
                break;
            case 'L':
                $formatedAnswer = "Grande";
                break;
            case 'XL':
                $formatedAnswer = "Extra grande";
                break;
            case 'XXL':
                $formatedAnswer = "2XL";
                break;
            case 'XXXL':
                $formatedAnswer = "3XL";
                break;
        }
        return $formatedAnswer;
    }
}
