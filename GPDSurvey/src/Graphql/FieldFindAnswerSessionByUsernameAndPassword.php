<?php

namespace GPDSurvey\Graphql;

use GPDCore\Contracts\AppContextInterface;
use GPDCore\Doctrine\QueryBuilderHelper;
use GPDSurvey\Entities\SurveyAnswerSession;

class FieldFindAnswerSessionByUsernameAndPassword
{

    public static function createReslove()
    {
        return function ($root, $args, AppContextInterface $context, $info) {
            $targetAudienceId = $args["targetAudience"];
            $username = $args["username"];
            $password = $args["password"];
            if (empty($username) || empty($password)) {
                return null;
            }
            $entityManager = $context->getEntityManager();
            $answerSession = static::findAnswerSession($context, $targetAudienceId, $username, $password);
            if (!($answerSession instanceof SurveyAnswerSession)) {
                return null;
            }
            $result = QueryBuilderHelper::fetchById($entityManager, SurveyAnswerSession::class, $answerSession->getId(), SurveyAnswerSession::RELATIONS_MANY_TO_ONE);
            return $result;
        };
    }
    protected static function findAnswerSession(AppContextInterface $context, $targetAudienceId, $username, $password): ?SurveyAnswerSession
    {
        $entityManager = $context->getEntityManager();
        $qb = $entityManager->createQueryBuilder()->from(SurveyAnswerSession::class, 'answerSession')->select("answerSession");
        $qb->andWhere('answerSession.targetAudience = :targetAudienceId')
            ->andWhere('answerSession.username like :username')
            ->andWhere('answerSession.password like :password')
            ->setParameter(':targetAudienceId', $targetAudienceId)
            ->setParameter(':username', $username)
            ->setParameter(':password', $password);
        $answerSession = $qb->getQuery()->getOneOrNullResult();
        return $answerSession;
    }
}
