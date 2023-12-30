<?php

declare(strict_types=1);

namespace GPDSurvey\Graphql\Types;

use GraphQL\Type\Definition\Type;
use GPDCore\Library\IContextService;
use GraphQL\Type\Definition\InputObjectType;
use GPDSurvey\Graphql\Types\TypeBuildSurveySectionInput;

class TypeBuildSurveyInput extends InputObjectType
{
    const NAME = 'BuildSurveyInput';
    public function __construct(IContextService $context)
    {
        $serviceManager = $context->getServiceManager();
        $config = [
            'name' => static::NAME,
            'fields' => [
                'title' => [
                    'type' => Type::nonNull(Type::string()),
                ],
                'sections' => [
                    'type' => Type::nonNull(Type::listOf(Type::nonNull($serviceManager->get(TypeBuildSurveySectionInput::class)))),
                ],
                'targetAudience' => [
                    'type' => $serviceManager->get(TypeBuildSurveyTargetAudienceInput::class)
                ],
                'active' => [
                    'type' => Type::nonNull(Type::boolean())
                ]

            ]
        ];

        parent::__construct($config);
    }
}
