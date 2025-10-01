<?php

namespace GPDSurvey\Library;

use GPDSurvey\Entities\Survey;
use GPDSurvey\Entities\SurveyAnswer;
use GPDSurvey\Entities\SurveyConfiguration;
use GPDSurvey\Entities\SurveyQuestion;

class SurveyScoreUtilities
{


    /**
     * Calcula el puntaje de la respuesta a una pregunta
     * Formato de configuración de puntajes ["type"=>?string, "scores"=>[["answer"=>string,"score"=>?float]]]
     * Para una respuesta que tiene score null se utiliza el score de la pregunta
     * Compara las respuestas sin espacios iniciales ni finales y en minúsculas
     * @param SurveyQuestion $question
     * @param string $answer
     * @return ?float
     */
    public static function calculateAnswerScore(SurveyQuestion $question, ?string $answerValue): ?float
    {
        // Si no se han asignado puntajes retorna null
        $answerScore = $question->getAnswerScore();
        if (!($answerScore instanceof SurveyConfiguration)) {
            return null;
        }
        $config = $answerScore->getValue();
        if (empty($config) || empty($config["scores"])) {
            return null;
        }
        if (empty($answerValue)) {
            return 0;
        }
        $scores = $config["scores"];
        //TODO: Implementar calculo de puntajes para opciones multiples definir como se van a guardar las opciones multiples por ejemplo array
        $findScoresConfig = array_filter($scores, function ($item) use ($answerValue) {
            if (empty($item["answer"])) {
                return false;
            }
            return strtolower(trim($item["answer"]))  == strtolower(trim($answerValue));
        });
        $findScoreConfig = array_values($findScoresConfig)[0];
        if (empty($findScoreConfig)) {
            return 0;
        }
        $score = $findScoreConfig["score"] ?? $question->getScore();

        return $score;
    }
    /**
     * Calcula el puntaje de la respuesta a una pregunta en porcentaje
     * Formato de configuración de puntajes ["type"=>?string, "scores"=>[["answer"=>string,"score"=>?float]]]
     * Para una respuesta que tiene score null se utiliza el score de la pregunta
     * Compara las respuestas sin espacios iniciales ni finales y en minúsculas
     * @param SurveyQuestion $question
     * @param string $answer
     * @return ?float
     */
    public static function calculateAnswerScorePercent(SurveyQuestion $question, ?float $score): ?float
    {
        $questionScore = $question->getScore();
        if (empty($questionScore) || $score === null) {
            return null;
        }
        if (empty($score)) {
            return 0;
        }
        $percent = $score / $questionScore;
        $percentFormated = round($percent * 10000) / 100;
        return $percentFormated;
    }
    /**
     * Calcula el puntaje de la session
     *
     * @param array $answers SurveyAnswer
     * @return [$score, $scorePercent]
     */
    public static function calculateAnswerSessionScore(array $answers): ?float
    {

        $answerWitScores = array_filter($answers, function (SurveyAnswer $answer) {
            return $answer->getScore() !== null;
        });
        if (empty($answerWitScores)) {
            return null;
        }
        $scores = array_map(function (SurveyAnswer $answer) {
            return $answer->getScore();
        }, $answerWitScores);
        $sum = array_reduce($scores, function ($acc, $score) {
            return $acc + $score;
        }, 0);
        return $sum;
    }
    /**
     * Calcula el puntaje de la session
     *
     * @param array $answers SurveyAnswer
     * @return [$score, $scorePercent]
     */
    public static function calculateAnswerSessionScorePercent(array $answers): ?float
    {

        $answerWitScores = array_filter($answers, function (SurveyAnswer $answer) {
            return $answer->getScore() !== null;
        });
        if (empty($answerWitScores)) {
            return null;
        }
        $totalScores = count($answerWitScores);
        $scores = array_map(function (SurveyAnswer $answer) {
            return $answer->getScorePercent();
        }, $answerWitScores);
        $sum = array_reduce($scores, function ($acc, $score) {
            return $acc + $score;
        }, 0);
        $average = $sum / $totalScores;
        $percent = round($average * 10000) / 100;
        return $percent;
    }
}
