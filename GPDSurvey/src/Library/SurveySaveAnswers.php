<?php

namespace GPDSurvey\Library;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\EntityManager;
use Exception;
use GPDCore\Library\GQLException;
use GPDCore\Library\IContextService;
use GPDSurvey\Entities\SurveyAnswer;
use GPDSurvey\Entities\SurveyAnswerSession;
use GPDSurvey\Entities\SurveyQuestion;

class SurveySaveAnswers
{
    /**
     * Guarda las respuestas en la base de datos
     *
     * @param IContextService $context
     * @param string $sessionId
     * @param array $answersInputs
     * @param array $questions [$questionID => SurveyQuestion]
     * @param DateTimeImmutable|null $starts
     * @param DateTimeImmutable|null $ends
     * @return array $answer SurveyAnswer[]
     */
    public static function save(IContextService $context, SurveyAnswerSession $session, array $answersInputs, array $questions, ?DateTimeImmutable $starts, ?DateTimeImmutable $ends, ?callable $answerScoreCalculator)
    {

        static::validateDate($starts, $ends);
        $answers = $session->getAnswers()->toArray();
        $entityManager = $context->getEntityManager();
        $result = [];
        foreach ($answersInputs as $key => $answerInput) {
            $answer = static::saveAnswer($entityManager, $answerInput, $answers, $session, $questions, $answerScoreCalculator);
            $result[] = $answer;
        }
        $entityManager->flush();
    }

    protected static function validateDate(?DateTimeImmutable $starts, ?DateTimeImmutable $ends)
    {
        $currentDate = new DateTimeImmutable();

        if ($starts instanceof DateTimeInterface && $starts > $currentDate) {
            throw new GQLException("Aún no ha iniciado el periodo para realizar la encuesta");
        }
        if ($ends instanceof DateTimeInterface && $ends < $currentDate) {
            throw new GQLException("Ha terminado el periodo para realizar la encuesta");
        }
    }


    /**
     * Recupara los datos de puntaje y de puntaje en porcentaje en un array con ese orden [puntaje, puntajePercent]
     * @param array $questions
     * @param string $answer [questionId=>string, value=>string]
     * @return [?float,?float]
     */
    protected static function calculateScoreValues(array $questions, array $answerInput, ?callable $answerScoreCalculator)
    {
        if (!is_callable($answerScoreCalculator)) {
            $answerScoreCalculator = static::getDefaultScoreCalculator();
        }
        $questionId = $answerInput["questionId"];
        $question = $questions[$questionId] ?? null;
        $answerValue = $answerInput["value"];
        $score = $answerScoreCalculator($question, $answerValue);
        $scorePercent = SurveyScoreUtilities::calculateAnswerScorePercent($question, $score);
        return [$score, $scorePercent];
    }


    protected static function saveAnswer(EntityManager $entityManager, array $answerInput, array $answers, SurveyAnswerSession $answerSession, $questions, ?callable $answerScoreCalculator): SurveyAnswer
    {
        // Se usa Doctrine en lugar de sql para que sea compatible con diferentes bases de datos


        $answer = static::findAnswer($answers, $answerInput);
        if (!($answer instanceof SurveyAnswer)) {
            $answer = static::createAnswer($entityManager, $answerInput, $questions, $answerSession, $answerScoreCalculator);
        } else {
            $answer = static::updateAnswer($answer, $answerInput, $questions, $answerScoreCalculator);
        }

        return $answer;
    }

    protected static function findAnswer(array $answers, array $answerInput): ?SurveyAnswer
    {
        $result = null;
        $questionId = $answerInput["questionId"];
        foreach ($answers as $answer) {
            if ($answer->getQuestion()->getId() === $questionId) {
                $result = $answer;
            }
        }
        return $result;
    }

    protected static function createAnswer(EntityManager $entityManager, array $answerInput, array $questions, SurveyAnswerSession $answerSession, ?callable $answerScoreCalculator): SurveyAnswer
    {
        $questionId = $answerInput["questionId"];
        $question = $questions[$questionId];
        $scoreValues = static::calculateScoreValues($questions, $answerInput, $answerScoreCalculator);
        $answer = new SurveyAnswer();
        $answer
            ->setSession($answerSession)
            ->setQuestion($question)
            ->setScore($scoreValues[0])
            ->setScorePercent($scoreValues[1])
            ->setValue($answerInput["value"]);
        $entityManager->persist($answer);
        return $answer;
    }

    protected static function updateAnswer(SurveyAnswer $answer, array $answerInput, array $questions, ?callable $answerScoreCalculator): SurveyAnswer
    {
        $scoreValues = static::calculateScoreValues($questions, $answerInput, $answerScoreCalculator);
        $currentDate = new DateTimeImmutable();
        $answer
            ->setValue($answerInput["value"])
            ->setScore($scoreValues[0])
            ->setScorePercent($scoreValues[1])
            ->setUpdated($currentDate);

        return $answer;
    }

    /** 
     * Como valor predeterminado si hay un error al calcular el puntaje no impide que se registre la respuesta.
     */
    protected static function getDefaultScoreCalculator()
    {
        return function (SurveyQuestion $question, $answerValue) {
            try {
                return  SurveyScoreUtilities::calculateAnswerScore($question, $answerValue);
            } catch (Exception $e) {
                return null;
            }
        };
    }
}
