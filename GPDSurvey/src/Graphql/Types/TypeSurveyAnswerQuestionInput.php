<?php

declare(strict_types=1);

namespace GPDSurvey\Graphql\Types;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

class TypeSurveyAnswerQuestionInput extends InputObjectType
{

    public function __construct()
    {
        $config = [
            'name' => 'SurveyAnswerQuestionInput',
            'fields' => [
                'questionId' => [
                    'type' => Type::nonNull(Type::string()),
                ],
                'value' => [
                    'type' => Type::string(),
                ],
            ]
        ];

        parent::__construct($config);
    }
}
