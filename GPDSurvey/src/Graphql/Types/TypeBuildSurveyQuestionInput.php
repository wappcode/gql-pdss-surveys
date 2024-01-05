<?php

declare(strict_types=1);

namespace GPDSurvey\Graphql\Types;

use GraphQL\Type\Definition\Type;
use GPDCore\Library\IContextService;
use GPDSurvey\Entities\SurveyConfiguration;
use GraphQL\Type\Definition\InputObjectType;
use GPDSurvey\Graphql\Types\TypeBuildSurveyContentInput;

class TypeBuildSurveyQuestionInput extends InputObjectType
{
    const NAME = 'BuildSurveyQuestionInput';
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
                    'type' => Type::id(),
                ],
                'title' => [
                    'type' => Type::nonNull(Type::string()),
                ],
                'code' => [
                    'type' => Type::nonNull(Type::string()),
                ],
                'type' => [
                    'type' => Type::nonNull(Type::string()),
                ],
                'required' => [
                    'type' => Type::nonNull(Type::boolean()),
                ],
                'other' => [
                    'type' => Type::boolean(),
                ],
                'hint' => [
                    'type' => Type::string(),
                ],
                'options' => [
                    'type' => Type::listOf($serviceManager->get(TypeBuildSurveyQuestionOptionInput::class))
                ],
                'content' => [
                    'type' => $serviceManager->get(TypeBuildSurveyContentInput::class)
                ],
                'presentation' => [
                    'type' => $types->getInput(SurveyConfiguration::class)
                ],
                'validators' => [
                    'type' => $types->getInput(SurveyConfiguration::class)
                ],
                'answerScore' => [
                    'type' => $types->getInput(SurveyConfiguration::class)
                ],
                'score' => [
                    'type' =>  Type::float()
                ],
                'survey' => [
                    'type' => Type::id(),
                ]


            ]
        ];

        parent::__construct($config);
    }
}
