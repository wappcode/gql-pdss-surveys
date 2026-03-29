<?php

namespace GPDSurvey\Graphql;

use GPDCore\Doctrine\QueryBuilderHelper;
use GPDCore\Contracts\AppContextInterface;
use GPDSurvey\Entities\SurveyAnswerSession;
use GPDSurvey\Entities\SurveyTargetAudience;
use GPDSurvey\Library\SurveySaveAnswerSession;

class FieldCreateAnswerSession
{



    public static function createResolve()
    {
        return function ($root, $args, AppContextInterface $context, $info) {
            $entityManager = $context->getEntityManager();
            $input = $args["input"];
            $answerInput = $input["answers"] ?? [];
            $targetAudienceId = $input["targetAudience"];
            $answerSessionInput = $input;
            unset($answerInput["answers"]);
            $targetAudience = $entityManager->find(SurveyTargetAudience::class, $targetAudienceId);
            $answerSession = SurveySaveAnswerSession::createAnswerSession($context, $targetAudience, $answerInput, $answerSessionInput);
            $result = QueryBuilderHelper::fetchById($entityManager, SurveyAnswerSession::class, $answerSession->getId(), SurveyAnswerSession::RELATIONS_MANY_TO_ONE);
            return $result;
        };
    }
}
