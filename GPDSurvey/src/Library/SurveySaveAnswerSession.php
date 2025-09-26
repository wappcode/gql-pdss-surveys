<?php

namespace GPDSurvey\Library;

use DateTimeImmutable;
use Exception;
use GPDCore\Library\IContextService;
use GPDSurvey\Entities\SurveyAnswer;
use GPDSurvey\Entities\SurveyAnswerSession;
use GPDSurvey\Entities\SurveyQuestion;
use GPDSurvey\Entities\SurveyTargetAudience;

class SurveySaveAnswerSession
{



    /**
     * Crea una sesión de respuestas
     *
     * @param IContextService $context
     * @param SurveyTargetAudience $targetAudience
     * @param array $answersInputs
     * @param array $answerSessionInput
     * @param callable|null $sessionScoreCalculator funcion para calcular el puntaje de una respuesta
     * @param callable|null $answerScoreCalculator funcion para calcular el puntaje de una respuesta parametros SurveyQuestion y ?string (valor de la respuesta);
     * @return SurveyAnswerSession
     */
    public static function createAnswerSession(IContextService $context, SurveyTargetAudience $targetAudience, array $answersInputs, array $answerSessionInput, ?callable $sessionScoreCalculator = null, ?callable $answerScoreCalculator = null): SurveyAnswerSession
    {

        $entityManager = $context->getEntityManager();
        $survey = $targetAudience->getSurvey();
        $answerSession = new SurveyAnswerSession();
        $answerSession->setTargetAudience($targetAudience)
            ->setSurvey($survey);
        static::updateAnswerSessionFromIput($answerSession, $answerSessionInput);
        $entityManager->persist($answerSession);
        $questions = $survey->getQuestions()->toArray();
        $questionsAdapted = static::adaptQuestions($questions);
        $starts = $targetAudience->getStarts();
        $ends = $targetAudience->getEnds();
        SurveySaveAnswers::save($context, $answerSession, $answersInputs, $questionsAdapted, $starts, $ends, $answerScoreCalculator);
        static::updateSessionScore($context, $answerSession, $sessionScoreCalculator);
        $entityManager->flush();
        return $answerSession;
    }

    public static function updateAnswerSession(IContextService $context, SurveyAnswerSession $answerSession, array $answersInputs, array $answerSessionInput, ?callable $sessionScoreCalculator = null, ?callable $answerScoreCalculator = null): SurveyAnswerSession
    {
        $entityManager = $context->getEntityManager();
        $targetAudience = $answerSession->getTargetAudience();
        $survey = $answerSession->getSurvey();
        $questions = $survey->getQuestions()->toArray();
        $questionsAdapted = static::adaptQuestions($questions);
        $starts = $targetAudience->getStarts();
        $ends = $targetAudience->getEnds();
        static::updateAnswerSessionFromIput($answerSession, $answerSessionInput);
        SurveySaveAnswers::save($context, $answerSession, $answersInputs, $questionsAdapted, $starts, $ends, $answerScoreCalculator);
        $answerSession->setUpdated(new DateTimeImmutable());
        static::updateSessionScore($context, $answerSession, $sessionScoreCalculator);
        $entityManager->flush();
        return $answerSession;
    }

    protected static function updateAnswerSessionFromIput(SurveyAnswerSession $answerSession, array $input)
    {
        $name = $input["name"] ?? null;
        $username = $input["username"] ?? null;
        $password = $input["password"] ?? null;
        $ownerCode = $input["ownerCode"] ?? null;
        $completed = $input["completed"] ?? null;
        if ($name !== null) {
            $answerSession->setName($name);
        }
        if ($username !== null) {
            $answerSession->setUsername($username);
        }
        if ($password !== null) {
            $answerSession->setPassword($password);
        }
        if ($ownerCode !== null) {
            $answerSession->setOwnerCode($ownerCode);
        }
        if ($completed !== null) {
            $answerSession->setCompleted($completed);
        }
    }

    protected static function adaptQuestions(array $questions)
    {
        $questionsList = [];
        /**@var SurveyQuestion */
        foreach ($questions as $question) {
            $questionsList[$question->getId()] = $question;
        }
        return $questionsList;
    }

    /**
     * Recupera una funcion que retorna un array tipo tuple con los valores de socre y scorePercent [?float,?float]
     * Por defecto solo se calcula el score cuando ha completado el cuestionario esto porque para este cálculo se utilizan el total de respuestas
     * para el cálculo global en caso de que esté incompleto porque el numero de respuestas puede ser diferente a las esperadas.
     * 
     * Si hay error en éste cálculo no afecta los demás procesos de guardado.
     * @param IContextService $context
     * @return callable
     */
    protected static function createDefaultSessionScoreValuesCalculator(IContextService $context)
    {

        return function (SurveyAnswerSession $session) use ($context) {



            if (!$session->getCompleted()) {
                return [null, null];
            }

            try {
                $sessionId = $session->getId();
                $entityManager = $context->getEntityManager();
                $qb = $entityManager->createQueryBuilder()->from(SurveyAnswer::class, 'answer')
                    ->innerJoin('answer.question', 'question')
                    ->select(["answer", "question"])
                    ->andWhere('answer.session = :sessionId')
                    ->setParameter(":sessionId", $sessionId);

                $answers = $qb->getQuery()->getResult();
                $score = SurveyScoreUtilities::calculateAnswerSessionScore($answers);
                $percentScore = SurveyScoreUtilities::calculateAnswerSessionScorePercent($answers);
                return [$score, $percentScore];
            } catch (Exception $e) {
                return [null, null];
            }
        };
    }

    protected static function updateSessionScore(IContextService $context, SurveyAnswerSession $answerSession, ?callable $sessionScoreCalculator)
    {
        $entityManager = $context->getEntityManager();
        if (!is_callable($sessionScoreCalculator)) {
            $sessionScoreCalculator = static::createDefaultSessionScoreValuesCalculator($context);
        }
        $scoreValues = $sessionScoreCalculator($answerSession);
        $answerSession->setScore($scoreValues[0])->setScorePercent($scoreValues[1]);
    }
}
