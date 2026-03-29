<?php

namespace GPDSurvey\Graphql;

use GPDCore\Contracts\AppContextInterface;
use GPDCore\Doctrine\QueryBuilderHelper;
use GPDSurvey\Entities\SurveyAnswerSession;

class FieldFindAnswerSessionByOwnerCode
{



    public static function createReslove()
    {
        return function ($root, $args, AppContextInterface $context, $info) {
            $targetAudienceId = $args["targetAudience"];
            $ownerCode = $args["ownerCode"];
            $entityManager = $context->getEntityManager();
            $answerSession = static::findAnswerSession($context, $targetAudienceId, $ownerCode);
            if (!($answerSession instanceof SurveyAnswerSession)) {
                return null;
            }
            $result = QueryBuilderHelper::fetchById($entityManager, SurveyAnswerSession::class, $answerSession->getId(), SurveyAnswerSession::RELATIONS_MANY_TO_ONE);
            return $result;
        };
    }
    protected static function findAnswerSession(AppContextInterface $context, $targetAudienceId, $ownwerCode): ?SurveyAnswerSession
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
