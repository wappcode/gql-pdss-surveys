<?php

namespace GPDSurvey\Graphql;

use GPDCore\Library\GeneralDoctrineUtilities;
use GPDCore\Library\IContextService;
use GPDSurvey\Entities\SurveyAnswerSession;
use GraphQL\Type\Definition\Type;

class FieldFindAnswerSessionByOwnerCode
{

    public static function get(IContextService $context, ?callable $proxy)
    {
        $type = $context->getTypes();
        $resolve = static::createReslove();
        $proxyResolve = is_callable($proxy) ? $proxy($resolve) : $resolve;
        return [
            'type' => $type->getOutput(SurveyAnswerSession::class),
            'args' => [
                'targetAudience' => Type::nonNull(Type::id()),
                'ownerCode' => Type::nonNull(Type::string()),
            ],
            'resolve' => $proxyResolve
        ];
    }

    protected static function createReslove()
    {
        return function ($root, $args, IContextService $context, $info) {
            $targetAudienceId = $args["targetAudience"];
            $ownerCode = $args["ownerCode"];
            $entityManager = $context->getEntityManager();
            $answerSession = static::findAnswerSession($context, $targetAudienceId, $ownerCode);
            if (!($answerSession instanceof SurveyAnswerSession)) {
                return null;
            }
            $result = GeneralDoctrineUtilities::getArrayEntityById($entityManager, SurveyAnswerSession::class, $answerSession->getId(), SurveyAnswerSession::RELATIONS_MANY_TO_ONE);
            return $result;
        };
    }
    protected static function findAnswerSession(IContextService $context, $targetAudienceId, $ownwerCode): ?SurveyAnswerSession
    {
        $entityManager = $context->getEntityManager();
        $qb = $entityManager->createQueryBuilder()->from(SurveyAnswerSession::class, 'answerSession')->select("answerSession");
        $qb->andWhere('answerSession.targetAudience = :targetAudienceId')
            ->andWhere('answerSession.ownerCode like :ownwerCode')
            ->setParameter(':targetAudienceId', $targetAudienceId)
            ->setParameter(':ownwerCode', $ownwerCode);
        $answerSession = $qb->getQuery()->getOneOrNullResult();
        return $answerSession;
    }
}
