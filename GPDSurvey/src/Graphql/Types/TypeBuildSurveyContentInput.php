<?php

declare(strict_types=1);

namespace GPDSurvey\Graphql\Types;

use GraphQL\Type\Definition\Type;
use GPDCore\Library\IContextService;
use GPDSurvey\Entities\SurveyConfiguration;
use GraphQL\Type\Definition\InputObjectType;
use GPDSurvey\Graphql\Types\TypeSurveyContentType;

class TypeBuildSurveyContentInput extends InputObjectType
{
    const NAME = 'BuildSurveyContentInput';
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
                    'type' => Type::nonNull($serviceManager->get(TypeSurveyContentType::class)),
                ],
                'body' => [
                    'type' => Type::string(),
                ],
                'presentation' => [
                    'type' => $types->getInput(SurveyConfiguration::class),
                ],

            ]
        ];

        parent::__construct($config);
    }
}
