<?php

namespace GPDSurvey\Graphql;

use Exception;
use GPDCore\Exceptions\GQLException;
use GraphQL\Type\Definition\Type;
use GPDCore\Contracts\AppContextInterface;
use GPDSurvey\Library\DeleteSurveyTargetAudience;

class FieldDeleteSurveyTargetAudience
{
    public static function get(AppContextInterface $context, ?callable $proxy)
    {
        $resolver = static::createReslove();
        $proxyResolver = is_callable($proxy) ? $proxy($resolver) : $resolver;
        return [
            'description' => "Elimna el registro de audiencia. No se pueden eliminar registros con respuestas relacionadas",
            'type' => Type::nonNull(Type::boolean()),
            'args' => [
                'id' => Type::nonNull(Type::id()),
            ],
            'resolve' => $proxyResolver,
        ];
    }
    protected static function createReslove()
    {
        return function ($root, $args, AppContextInterface $context, $info) {
            $entityManager = $context->getEntityManager();
            $id = $args["id"];
            if (empty($id)) {
                throw new GQLException("Invalid ID");
            }
            $entityManager->beginTransaction();
            try {
                DeleteSurveyTargetAudience::delete($context, $id);
                $entityManager->commit();
                return true;
            } catch (Exception $e) {
                $entityManager->rollback();
                throw $e;
            }
        };
    }
}
