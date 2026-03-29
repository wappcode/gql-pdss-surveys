<?php

namespace GPDSurvey\Graphql;

use Exception;
use GPDCore\Exceptions\GQLException;
use GraphQL\Type\Definition\Type;
use GPDCore\Contracts\AppContextInterface;
use GPDSurvey\Library\DeleteSurveyQuestion;

class FieldDeleteSurveyQuestion
{
    public static function get(AppContextInterface $context, ?callable $proxy)
    {
        $resolver = static::createReslove();
        $proxyResolver = is_callable($proxy) ? $proxy($resolver) : $resolver;
        return [
            'description' => "Elimna la pregunta. No se pueden eliminar preguntas con respuestas",
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
                DeleteSurveyQuestion::delete($context, $id);
                $entityManager->commit();
                return true;
            } catch (Exception $e) {
                $entityManager->rollback();
                throw $e;
            }
        };
    }
}
