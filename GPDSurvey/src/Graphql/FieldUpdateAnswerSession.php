<?php

namespace GPDSurvey\Graphql;

use GPDCore\Doctrine\QueryBuilderHelper;
use GPDCore\Exceptions\GQLException;
use GPDCore\Contracts\AppContextInterface;
use GPDSurvey\Entities\SurveyAnswerSession;
use GPDSurvey\Library\SurveySaveAnswerSession;
use GraphQL\Type\Definition\Type;

class FieldUpdateAnswerSession
{

    public static function createResolve()
    {
        return function ($root, $args, AppContextInterface $context, $info) {
            $entityManager = $context->getEntityManager();
            $id = $args["id"];
            $input = $args["input"];
            unset($input["ownerCode"], $input["targetAudience"]); // se quita del input ownerCode y targetAudience porque estos valores núnca deben cambiar
            $answerInput = $input["answers"] ?? [];
            $answerSessionInput = $input;
            unset($answerInput["answers"]);
            $answerSession = $entityManager->find(SurveyAnswerSession::class, $id);
            if (!($answerSession instanceof SurveyAnswerSession)) {
                throw new GQLException("The session doesn't exist", 400);
            }
            SurveySaveAnswerSession::updateAnswerSession($context, $answerSession, $answerInput, $answerSessionInput);
            $result = QueryBuilderHelper::fetchById($entityManager, SurveyAnswerSession::class, $answerSession->getId(), SurveyAnswerSession::RELATIONS_MANY_TO_ONE);
            return $result;
        };
    }
}
