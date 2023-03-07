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
                'type' => [
                    'type' => Type::nonNull($serviceManager->get(TypeSurveySectionItemType::class))
                ],
                'order' => [
                    'type' => Type::nonNull(Type::int())
                ],
                'conditions' => [
                    'type' => Type::listOf($types->getInput(SurveyConfiguration::class))
                ],
                'question' => [
                    'type' => Type::listOf($serviceManager->get(TypeBuildSurveyQuestionInput::class))
                ],
                'content' => [
                    'type' => $serviceManager->get(TypeBuildSurveyContentInput::class)
                ],
                'hidden' => [
                    'type' => Type::boolean()
                ],
            ]
        ];

        parent::__construct($config);
    }
}
