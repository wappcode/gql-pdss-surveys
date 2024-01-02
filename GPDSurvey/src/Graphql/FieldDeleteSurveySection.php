<?php

namespace GPDSurvey\Graphql;

use DeleteSurveySection;
use Exception;
use GPDSurvey\Entities\Survey;
use GPDCore\Library\GQLException;
use GraphQL\Type\Definition\Type;
use GPDCore\Library\IContextService;
use GPDSurvey\Entities\SurveySection;

class FieldDeleteSurveySection
{
    public static function get(IContextService $context, ?callable $proxy)
    {
        $resolver = static::createReslove();
        $proxyResolver = is_callable($proxy) ? $proxy($resolver) : $resolver;
        return [
            'description' => "Elimna la sección. No se pueden eliminar secciones que tengan preguntas con respuestas",
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
                DeleteSurveySection::delete($context, $id);
                $entityManager->commit();
                return true;
            } catch (Exception $e) {
                $entityManager->rollback();
                throw $e;
            }
        };
    }
}
