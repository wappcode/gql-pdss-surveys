<?php

namespace GPDSurvey\Library;


class QuestionOptionsValueUtilities
{


    /**
     * Formatea una respuesta utilizando las opciones de la pregunta y aplica un formato especial para imagenes y archivos
     *
     * @param array $question array con los nombres de las columnas de la base como clave ["question_type"] o ["type"]
     * @param array $options Opciones de la pregunta
     * @param string|null $answer
     * @param string|null $fileUrlBase (url para descargar o ver archivo al final de la url se agrega la respuesta https://demo.com/updloads/{respuesta})
     * @return string|null
     */
    public static function getFormatedAnswer(array $question, array $options, ?string $answer, ?string $fileUrlBase = null): ?string
    {
        if (empty($answer)) {
            return $answer;
        }
        $type = $question["type"] ?? $question["question_type"];
        $formatedAnswer = $answer;
        switch ($type) {
            case ISurveyQuestion::SURVEY_QUESTION_TYPE_CHECKBOX_LIST:
            case ISurveyQuestion::SURVEY_QUESTION_TYPE_RADIO_LIST:
                $formatedAnswer = static::formatQuestionOption($options, $answer);
                break;
            case ISurveyQuestion::SURVEY_QUESTION_TYPE_IMAGE:
            case ISurveyQuestion::SURVEY_QUESTION_TYPE_FILE:
                $formatedAnswer = static::formatQuestionFile($answer, $fileUrlBase);
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

    protected static function formatQuestionFile(string $answer, ?string $fileUrlBase = null): string
    {
        if (!is_string($fileUrlBase) || empty($fileUrlBase)) {
            $fileUrlBase = $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] . DIRECTORY_SEPARATOR . "uploads";
        }
        if (!empty($answer)) {
            $url = $fileUrlBase . DIRECTORY_SEPARATOR . $answer;
            return  $url;
        } else {
            return "";
        }
    }
}
