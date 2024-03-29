<?php

declare(strict_types=1);

namespace GPDSurvey\Graphql\Types;

use GraphQL\Type\Definition\Type;
use GPDCore\Library\IContextService;
use GPDSurvey\Entities\SurveyConfiguration;
use GraphQL\Type\Definition\InputObjectType;
use GPDSurvey\Graphql\Types\TypeSurveySectionItemType;
use GPDSurvey\Graphql\Types\TypeBuildSurveyQuestionInput;

class TypeBuildSurveySectionItemInput extends InputObjectType
{
    const NAME = 'BuildSurveySectionItemInput';
    /**
     * @var IContextService
     */
    protected $context;

    public function __construct(IContextService $context)
    {
        $this->context = $context;
        $serviceManager = $this->context->getServiceManager();
        $types = $this->context->getTypes();
        $config = [
            'name' => static::NAME,
            'fields' => [
                'id' => [
                    'type' => Type::id()
                ],
                'type' => [
                    'type' => Type::nonNull($serviceManager->get(TypeSurveySectionItemType::class))
                ],
                'order' => [
                    'type' => Type::nonNull(Type::int())
                ],
                'conditions' => [
                    'type' => $types->getInput(SurveyConfiguration::class)
                ],
                'question' => [
                    'type' => $serviceManager->get(TypeBuildSurveyQuestionInput::class)
                ],
                'content' => [
                    'type' => $serviceManager->get(TypeBuildSurveyContentInput::class)
                ],
                'hidden' => [
                    'type' => Type::nonNull(Type::boolean())
                ],
                'section' => [
                    'type' => Type::id()
                ]
            ]
        ];

        parent::__construct($config);
    }
}
