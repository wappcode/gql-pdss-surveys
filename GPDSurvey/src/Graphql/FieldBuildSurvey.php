<?php

namespace GPDSurvey\Graphql;

use Exception;
use GPDCore\Library\GeneralDoctrineUtilities;
use GPDCore\Library\GQLException;
use GPDSurvey\Entities\Survey;
use GPDCore\Library\IContextService;
use GPDSurvey\Graphql\Types\TypeBuildSurveyInput;
use GPDSurvey\Library\BuildSurvey;

class FieldBuildSurvey
{
    public static function get(IContextService $context, ?callable $proxy)
    {
        $types = $context->getTypes();
        $serviceManager = $context->getServiceManager();
        $resolve = static::createReslove();
        $proxyResolve = is_callable($proxy) ? $proxy($resolve) : $resolve;
        return [
            'type' => $types->getOutput(Survey::class),
            'args' => [
                'input' => $serviceManager->get(TypeBuildSurveyInput::class)
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
                $survey = BuildSurvey::build($context, $input);
                if (!($survey instanceof Survey)) {
                    throw new GQLException("Invalid request", 400);
                }
                $entityManager->commit();
                $result = GeneralDoctrineUtilities::getArrayEntityById($entityManager, Survey::class, $survey->getId(), Survey::RELATIONS_MANY_TO_ONE);
                return $result;
            } catch (Exception $e) {
                $entityManager->rollback();
                throw $e;
            }
        };
    }
}
