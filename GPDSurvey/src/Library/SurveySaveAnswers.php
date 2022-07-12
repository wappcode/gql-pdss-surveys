<?php

namespace GPDSurvey\Library;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\EntityManager;
use GPDCore\Library\GQLException;
use GPDCore\Library\IContextService;
use GPDSurvey\Entities\SurveyAnswer;
use GPDSurvey\Entities\SurveyAnswerSession;

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
    public static function save(IContextService $context, SurveyAnswerSession $session, array $answersInputs, array $questions, ?DateTimeImmutable $starts, ?DateTimeImmutable $ends)
    {
        static::validateDate($starts, $ends);
        $answers = $session->getAnswers()->toArray();
        $entityManager = $context->getEntityManager();
        $result = [];
        foreach ($answersInputs as $key => $answerInput) {
            $answer = static::saveAnswer($entityManager, $answerInput, $answers, $session, $questions);
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
     *
     * @param array $questions
     * @param string $answer [questionId=>string, value=>string]
     * @return void
     */
    protected static function calculateScore(array $questions, array $answerInput)
    {
        $questionId = $answerInput["questionId"];
        $question = $questions[$questionId] ?? null;
        $answerValue = $answerInput["value"];
        return SurveyScoreUtilities::calculateAnswerScoreValues($question, $answerValue);
    }


    protected static function saveAnswer(EntityManager $entityManager, array $answerInput, array $answers, SurveyAnswerSession $answerSession, $questions): SurveyAnswer
    {
        // Se usa Doctrine en lugar de sql para que sea compatible con diferentes bases de datos


        $scoreValue = static::calculateScore($questions, $answerInput);
        $answer = static::findAnswer($answers, $answerInput);
        if (!($answer instanceof SurveyAnswer)) {
            $answer = static::createAnswer($entityManager, $answerInput, $questions, $answerSession);
        } else {
            $answer = static::updateAnswer($answer, $answerInput, $questions);
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

    protected static function createAnswer(EntityManager $entityManager, array $answerInput, array $questions, SurveyAnswerSession $answerSession): SurveyAnswer
    {
        $questionId = $answerInput["questionId"];
        $question = $questions[$questionId];
        $scoreValue = static::calculateScore($questions, $answerInput);
        $answer = new SurveyAnswer();
        $answer
            ->setSession($answerSession)
            ->setQuestion($question)
            ->setScore($scoreValue[0])
            ->setScorePercent($scoreValue[1])
            ->setValue($answerInput["value"]);
        $entityManager->persist($answer);
        return $answer;
    }

    protected static function updateAnswer(SurveyAnswer $answer, array $answerInput, array $questions): SurveyAnswer
    {
        $scoreValue = static::calculateScore($questions, $answerInput);
        $currentDate = new DateTimeImmutable();
        $answer
            ->setValue($answerInput["value"])
            ->setScore($scoreValue[0])
            ->setScorePercent($scoreValue[1])
            ->setUpdated($currentDate);

        return $answer;
    }
}
