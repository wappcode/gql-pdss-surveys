<?php

declare(strict_types=1);

namespace GPDSurvey\Graphql\Types;

use DateTime;
use GraphQL\Type\Definition\Type;
use GPDCore\Library\IContextService;
use GPDSurvey\Entities\SurveyConfiguration;
use GraphQL\Type\Definition\InputObjectType;
use GPDSurvey\Graphql\Types\TypeBuildSurveyContentInput;

class TypeBuildSurveyTargetAudienceInput extends InputObjectType
{
    const NAME = 'BuildSurveyTargetAudienceInput';
    public function __construct(IContextService $context)
    {
        $serviceManager = $context->getServiceManager();
        $types = $context->getTypes();
        $config = [
            'name' => static::NAME,
            'fields' => [
                'title' => [
                    'type' => Type::nonNull(Type::string()),
                ],
                'starts' => [
                    'type' => $serviceManager->get(DateTime::class),
                ],
                'ends' => [
                    'type' => $serviceManager->get(DateTime::class),
                ],
                'welcome' => [
                    'type' => $serviceManager->get(TypeBuildSurveyContentInput::class),
                ],
                'farewell' => [
                    'type' => $serviceManager->get(TypeBuildSurveyContentInput::class),
                ],
                'attempts' => [
                    'type' => Type::int(),
                ],
                'presentation' => [
                    'type' => $types->getInput(SurveyConfiguration::class),
                ],
                'password' => [
                    'type' => Type::string()
                ]
            ]
        ];

        parent::__construct($config);
    }
}
