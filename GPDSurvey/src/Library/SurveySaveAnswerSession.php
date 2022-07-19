<?php

namespace GPDSurvey\Library;

use DateTimeImmutable;
use GPDCore\Library\IContextService;
use GPDSurvey\Entities\SurveyAnswerSession;
use GPDSurvey\Entities\SurveyQuestion;
use GPDSurvey\Entities\SurveyTargetAudience;

class SurveySaveAnswerSession
{



    public static function createAnswerSession(IContextService $context, SurveyTargetAudience $targetAudience, array $answersInputs, array $answerSessionInput): SurveyAnswerSession
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
        SurveySaveAnswers::save($context, $answerSession, $answersInputs, $questionsAdapted, $starts, $ends);
        // @TODO calcular puntaje y asignarlo
        return $answerSession;
    }

    public static function updateAnswerSession(IContextService $context, SurveyAnswerSession $answerSession, array $answersInputs, array $answerSessionInput): SurveyAnswerSession
    {
        $targetAudience = $answerSession->getTargetAudience();
        $survey = $answerSession->getSurvey();
        $questions = $survey->getQuestions()->toArray();
        $questionsAdapted = static::adaptQuestions($questions);
        $starts = $targetAudience->getStarts();
        $ends = $targetAudience->getEnds();
        static::updateAnswerSessionFromIput($answerSession, $answerSessionInput);
        SurveySaveAnswers::save($context, $answerSession, $answersInputs, $questionsAdapted, $starts, $ends);
        $answerSession->setUpdated(new DateTimeImmutable());
        // @TODO calcular puntaje y asignarlo
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
}
