<?php

namespace GPDSurvey\Graphql;

use Exception;
use GPDCore\Library\GQLException;
use GraphQL\Type\Definition\Type;
use GPDCore\Library\IContextService;
use GPDCore\Library\GeneralDoctrineUtilities;
use GPDSurvey\Entities\SurveyQuestion;
use GPDSurvey\Graphql\Types\TypeBuildSurveyQuestionInput;
use GPDSurvey\Library\BuildSurveyQuestion;

class FieldBuildSurveyQuestion
{
    public static function get(IContextService $context, ?callable $proxy)
    {
        $types = $context->getTypes();
        $serviceManager = $context->getServiceManager();
        $resolve = static::createReslove();
        $proxyResolve = is_callable($proxy) ? $proxy($resolve) : $resolve;
        return [
            'type' => $types->getOutput(SurveyQuestion::class),
            'description' => "Construye un registro SurveyQuestion puede actualizar un registro  si se asigna un id válido. 
            La actualización no es parcial elimina los elementos del registro previo que no esten en el input.
            ",

            'args' => [
                'input' =>  Type::nonNull($serviceManager->get(TypeBuildSurveyQuestionInput::class))
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
                $question = BuildSurveyQuestion::build($context, $input);
                if (!($question instanceof SurveyQuestion)) {
                    throw new GQLException("Invalid request", 400);
                }
                $entityManager->commit();
                $result = GeneralDoctrineUtilities::getArrayEntityById($entityManager, SurveyQuestion::class, $question->getId());
                return $result;
            } catch (Exception $e) {
                $entityManager->rollback();
                throw $e;
            }
        };
    }
}
