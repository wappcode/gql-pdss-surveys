<?php

namespace GPDSurvey\Graphql;

use Exception;
use GPDCore\Library\GQLException;
use GraphQL\Type\Definition\Type;
use GPDCore\Library\IContextService;
use GPDSurvey\Library\DeleteSurveySectionItem;

class FieldDeleteSurveySectionItem
{
    public static function get(IContextService $context, ?callable $proxy)
    {
        $resolver = static::createReslove();
        $proxyResolver = is_callable($proxy) ? $proxy($resolver) : $resolver;
        return [
            'description' => "Elimna un elemento de una sección. No se pueden eliminar items que tengan preguntas con respuestas",
            'type' => Type::nonNull(Type::boolean()),
            'args' => [
                'id' => Type::nonNull(Type::id()),
            ],
            'resolve' => $proxyResolver,
        ];
    }
    protected function createReslove()
    {
        return function ($root, $args, IContextService $context, $info) {
            $entityManager = $context->getEntityManager();

            $id = $args["id"];
            if (empty($id)) {
                throw new GQLException("Invalid ID");
            }

            $entityManager->beginTransaction();
            try {
                DeleteSurveySectionItem::delete($context, $id);
                $entityManager->commit();
                return true;
            } catch (Exception $e) {
                $entityManager->rollback();
                throw $e;
            }
        };
    }
}
