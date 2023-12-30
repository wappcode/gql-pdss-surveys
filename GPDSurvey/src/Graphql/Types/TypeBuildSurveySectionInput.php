<?php

declare(strict_types=1);

namespace GPDSurvey\Graphql\Types;

use GraphQL\Type\Definition\Type;
use GPDCore\Library\IContextService;
use GPDSurvey\Entities\SurveyConfiguration;
use GraphQL\Type\Definition\InputObjectType;
use GPDSurvey\Graphql\Types\TypeBuildSurveyContentInput;

class TypeBuildSurveySectionInput extends InputObjectType
{
    const NAME = 'BuildSurveySectionInput';
    /**
     * @var IContextService
     */
    private $context;
    public function __construct(IContextService $context)
    {
        $this->context = $context;
        $serviceManager = $this->context->getServiceManager();
        $types = $this->context->getTypes();
        $config = [
            'name' => static::NAME,
            'fields' => [
                'title' => [
                    'type' => Type::nonNull(Type::string()),
                ],
                'content' => [
                    'type' => $serviceManager->get(TypeBuildSurveyContentInput::class),
                ],
                'presentation' => [
                    'type' => $types->getInput(SurveyConfiguration::class),
                ],
                'order' => [
                    'type' => Type::nonNull(Type::int())
                ],
                'hidden' => [
                    'type' => Type::nonNull(Type::boolean())
                ],
                'items' => [
                    'type' => Type::listOf($serviceManager->get(TypeBuildSurveySectionItemInput::class))
                ]

            ]
        ];

        parent::__construct($config);
    }
}
