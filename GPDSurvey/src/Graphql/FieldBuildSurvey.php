<?php

namespace GPDSurvey\Graphql;

use GPDSurvey\Entities\Survey;
use GPDCore\Library\IContextService;
use GPDSurvey\Graphql\Types\TypeBuildSurveyInput;

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
        };
    }
}
