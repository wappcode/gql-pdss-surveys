<?php

namespace GPDSurvey\Graphql;

use Exception;
use GPDCore\Library\GQLException;
use GraphQL\Type\Definition\Type;
use GPDCore\Library\IContextService;
use GPDSurvey\Entities\SurveySection;
use GPDSurvey\Library\BuildSurveySection;
use GPDCore\Library\GeneralDoctrineUtilities;
use GPDSurvey\Graphql\Types\TypeBuildSurveySectionInput;

class FieldBuildSurveySection
{
    public static function get(IContextService $context, ?callable $proxy)
    {
        $types = $context->getTypes();
        $serviceManager = $context->getServiceManager();
        $resolve = static::createReslove();
        $proxyResolve = is_callable($proxy) ? $proxy($resolve) : $resolve;
        return [
            'type' => $types->getOutput(SurveySection::class),
            'description' => "Construye un registro SurveySection puede actualizar un registro  si se asigna un id válido. 
            La actualización no es parcial elimina los elementos del registro previo que no esten en el input.
            ",

            'args' => [
                'input' =>  Type::nonNull($serviceManager->get(TypeBuildSurveySectionInput::class))
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
                $section = BuildSurveySection::build($context, $input);
                if (!($section instanceof SurveySection)) {
                    throw new GQLException("Invalid request", 400);
                }
                $entityManager->commit();
                $result = GeneralDoctrineUtilities::getArrayEntityById($entityManager, SurveySection::class, $section->getId());
                return $result;
            } catch (Exception $e) {
                $entityManager->rollback();
                throw $e;
            }
        };
    }
}
