<?php

namespace GPDSurvey\Graphql;

use GPDCore\Library\GeneralDoctrineUtilities;
use GPDCore\Library\IContextService;
use GPDSurvey\Entities\SurveyAnswerSession;
use GPDSurvey\Entities\SurveyTargetAudience;
use GPDSurvey\Library\SurveySaveAnswers;
use GPDSurvey\Library\SurveySaveAnswerSession;

class FieldCreateAnswerSession
{

    public static function get(IContextService $context, ?callable $proxy)
    {
        $type = $context->getTypes();
        $resolve = static::createReslove();
        $proxyResolve = is_callable($proxy) ? $proxy($resolve) : $resolve;
        return [
            'type' => $type->getOutput(SurveyAnswerSession::class),
            'args' => [
                'input' => $type->getInput(SurveyAnswerSession::class)
            ],
            'resolve' => $proxyResolve
        ];
    }

    protected static function createReslove()
    {
        return function ($root, $args, IContextService $context, $info) {
            $entityManager = $context->getEntityManager();
            $input = $args["input"];
            $answerInput = $input["answers"] ?? [];
            $targetAudienceId = $input["targetAudience"];
            $answerSessionInput = $input;
            unset($answerInput["answers"]);
            $targetAudience = $entityManager->find(SurveyTargetAudience::class, $targetAudienceId);
            $answerSession = SurveySaveAnswerSession::createAnswerSession($context, $targetAudience, $answerInput, $answerSessionInput);
            $result = GeneralDoctrineUtilities::getArrayEntityById($entityManager, SurveyAnswerSession::class, $answerSession->getId(), SurveyAnswerSession::RELATIONS_MANY_TO_ONE);
            return $result;
        };
    }
}
