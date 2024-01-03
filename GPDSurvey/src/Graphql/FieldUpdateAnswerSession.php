<?php

namespace GPDSurvey\Graphql;

use GPDCore\Library\GeneralDoctrineUtilities;
use GPDCore\Library\GQLException;
use GPDCore\Library\IContextService;
use GPDSurvey\Entities\SurveyAnswerSession;
use GPDSurvey\Entities\SurveyTargetAudience;
use GPDSurvey\Library\SurveySaveAnswers;
use GPDSurvey\Library\SurveySaveAnswerSession;
use GraphQL\Type\Definition\Type;

class FieldUpdateAnswerSession
{

    public static function get(IContextService $context, ?callable $proxy)
    {
        $type = $context->getTypes();
        $resolve = static::createReslove();
        $proxyResolve = is_callable($proxy) ? $proxy($resolve) : $resolve;
        return [
            'type' => $type->getOutput(SurveyAnswerSession::class),
            'args' => [
                'id' => Type::nonNull(Type::id()),
                'input' => $type->getPartialInput(SurveyAnswerSession::class)
            ],
            'resolve' => $proxyResolve
        ];
    }

    protected static function createReslove()
    {
        return function ($root, $args, IContextService $context, $info) {
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
            $result = GeneralDoctrineUtilities::getArrayEntityById($entityManager, SurveyAnswerSession::class, $answerSession->getId(), SurveyAnswerSession::RELATIONS_MANY_TO_ONE);
            return $result;
        };
    }
}
