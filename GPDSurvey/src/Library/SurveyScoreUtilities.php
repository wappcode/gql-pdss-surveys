<?php

namespace GPDSurvey\Library;

use GPDSurvey\Entities\Survey;
use GPDSurvey\Entities\SurveyAnswer;
use GPDSurvey\Entities\SurveyQuestion;

class SurveyScoreUtilities
{


    /**
     * Calcula los valores del puntaje de la respuesta a una pregunta
     *
     * @param SurveyQuestion $question
     * @param string $answer
     * @return [$score, $scorePercent]
     */
    public static function calculateAnswerScoreValues(SurveyQuestion $question, ?string $answerValue)
    {
        //@TODO implementar método

        return [null, null];
    }
    /**
     * Calcula los valores del puntaje de la session
     *
     * @param array $answers SurveyAnswer
     * @return [$score, $scorePercent]
     */
    public static function calculateAnswerSessionScoreValues(array $answers)
    {
        //@TODO implementar método

        return [null, null];
    }
}
