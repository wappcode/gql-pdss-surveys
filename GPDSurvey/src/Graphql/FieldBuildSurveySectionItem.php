<?php

namespace GPDSurvey\Graphql;

use Exception;
use GPDCore\Library\GQLException;
use GraphQL\Type\Definition\Type;
use GPDCore\Library\IContextService;
use GPDCore\Library\GeneralDoctrineUtilities;
use GPDSurvey\Entities\SurveySectionItem;
use GPDSurvey\Graphql\Types\TypeBuildSurveySectionItemInput;
use GPDSurvey\Library\BuildSurveySectionItem;

class FieldBuildSurveySectionItem
{
    public static function get(IContextService $context, ?callable $proxy)
    {
        $types = $context->getTypes();
        $serviceManager = $context->getServiceManager();
        $resolve = static::createReslove();
        $proxyResolve = is_callable($proxy) ? $proxy($resolve) : $resolve;
        return [
            'type' => $types->getOutput(SurveySectionItem::class),
            'description' => "Construye un registro FieldBuildSurveySectionItem puede actualizar un registro  si se asigna un id válido. 
            La actualización no es parcial elimina los elementos del registro previo que no esten en el input.
            ",

            'args' => [
                'input' =>  Type::nonNull($serviceManager->get(TypeBuildSurveySectionItemInput::class))
            ],
            'resolve' => $proxyResolve
        ];
    }

    protected static function createReslove()
    {
        return function ($root, $args, IContextService $context, $info) {
            $input = $args["input"];
            $entityManager = $context->getEntityManager();
            $entityManager->beginTransaction();
            try {
                $item = BuildSurveySectionItem::build($context, $input);
                if (!($item instanceof SurveySectionItem)) {
                    throw new GQLException("Invalid request", 400);
                }
                $entityManager->commit();
                $result = GeneralDoctrineUtilities::getArrayEntityById($entityManager, SurveySectionItem::class, $item->getId());
                return $result;
            } catch (Exception $e) {
                $entityManager->rollback();
                throw $e;
            }
        };
    }
}
