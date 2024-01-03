<?php

namespace GPDSurvey\Graphql;

use Exception;
use GPDCore\Library\GeneralDoctrineUtilities;
use GPDCore\Library\GQLException;
use GPDSurvey\Entities\Survey;
use GPDCore\Library\IContextService;
use GPDSurvey\Entities\SurveyTargetAudience;
use GPDSurvey\Graphql\Types\TypeBuildSurveyTargetAudienceInput;
use GPDSurvey\Library\BuildSurvey;
use GPDSurvey\Library\BuildSurveyTargetAudience;
use GraphQL\Type\Definition\Type;

class FieldBuildSurveyTargetAudience
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
                'input' =>  Type::nonNull($serviceManager->get(TypeBuildSurveyTargetAudienceInput::class))
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
                $audience = BuildSurveyTargetAudience::build($context, $input);
                if (!($audience instanceof SurveyTargetAudience)) {
                    throw new GQLException("Invalid request", 400);
                }
                $entityManager->commit();
                $result = GeneralDoctrineUtilities::getArrayEntityById($entityManager, SurveyTargetAudience::class, $audience->getId(), SurveyTargetAudience::RELATIONS_MANY_TO_ONE);
                return $result;
            } catch (Exception $e) {
                $entityManager->rollback();
                throw $e;
            }
        };
    }
}
