<?php

namespace GPDSurvey\Graphql;

use Exception;
use GPDCore\Library\GQLException;
use GraphQL\Type\Definition\Type;
use GPDCore\Library\IContextService;
use GPDSurvey\Library\DeleteSurveyAnswerSession;

class FieldDeleteSurveyAnswerSession
{
    public static function get(IContextService $context, ?callable $proxy)
    {
        $resolver = static::createReslove();
        $proxyResolver = is_callable($proxy) ? $proxy($resolver) : $resolver;
        return [
            'type' => Type::nonNull(Type::boolean()),
            'args' => [
                'id' => Type::nonNull(Type::id()),
            ],
            'resolve' => $proxyResolver,
        ];
    }
    protected static function createReslove()
    {
        return function ($root, $args, IContextService $context, $info) {
            $entityManager = $context->getEntityManager();
            $id = $args["id"];
            if (empty($id)) {
                throw new GQLException("Invalid ID");
            }
            $entityManager->beginTransaction();
            try {
                DeleteSurveyAnswerSession::delete($context, $id);
                $entityManager->commit();
                return true;
            } catch (Exception $e) {
                $entityManager->rollback();
                throw $e;
            }
        };
    }
}
