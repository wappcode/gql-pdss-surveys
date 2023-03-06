<?php

namespace GPDSurvey\Graphql;

use GPDCore\Library\IContextService;
use GPDSurvey\Entities\SurveyAnswerSession;

class FieldCreateAnswerSession
{

    public static function get(IContextService $context, callable $proxy)
    {
        $type = $context->getTypes();
        $resolve = static::createReslove();
        $proxyResolve = is_callable($proxy) ? $proxy($resolve) : $resolve;
        return [
            'type' => $type->getOutput(SurveyAnswerSession::class),
            'args' => [
                'input' => $type->getInput(SurveyAnswerSession::class)
            ],
            'resolve' => $proxyResolve
        ];
    }

    protected static function createReslove()
    {
        return function ($root, $args, IContextService $config, $info) {
        };
    }
}
