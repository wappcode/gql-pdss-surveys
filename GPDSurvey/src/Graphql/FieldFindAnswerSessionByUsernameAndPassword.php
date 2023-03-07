<?php

namespace GPDSurvey\Graphql;

use GPDCore\Library\GeneralDoctrineUtilities;
use GPDCore\Library\IContextService;
use GPDSurvey\Entities\SurveyAnswerSession;
use GraphQL\Type\Definition\Type;

class FieldFindAnswerSessionByUsernameAndPassword
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
                'username' => Type::nonNull(Type::string()),
                'password' => Type::nonNull(Type::string())
            ],
            'resolve' => $proxyResolve
        ];
    }

    protected static function createReslove()
    {
        return function ($root, $args, IContextService $context, $info) {
            $targetAudienceId = $args["targetAudience"];
            $username = $args["username"];
            $password = $args["password"];
            $entityManager = $context->getEntityManager();
            $answerSession = static::findAnswerSession($context, $targetAudienceId, $username, $password);
            if (!($answerSession instanceof SurveyAnswerSession)) {
                return null;
            }
            $result = GeneralDoctrineUtilities::getArrayEntityById($entityManager, SurveyAnswerSession::class, $answerSession->getId(), SurveyAnswerSession::RELATIONS_MANY_TO_ONE);
            return $result;
        };
    }
    protected static function findAnswerSession(IContextService $context, $targetAudienceId, $username, $password): ?SurveyAnswerSession
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
