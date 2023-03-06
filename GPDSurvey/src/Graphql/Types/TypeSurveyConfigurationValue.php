<?php

declare(strict_types=1);

namespace GPDSurvey\Graphql\Types;

use Exception;
use GraphQL\Error\Error;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Language\AST\StringValueNode;

final class TypeSurveyConfigurationValue extends ScalarType
{
    const NAME = 'SurveyConfigurationValue';
    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->name = static::NAME;
    }
    public function parseLiteral($valueNode, array $variables = null)
    {
        // Note: throwing GraphQL\Error\Error vs \UnexpectedValueException to benefit from GraphQL
        // error location in query:
        if (!($valueNode instanceof StringValueNode)) {
            throw new Error('Query error: Can only parse strings got: ' . $valueNode->kind, $valueNode);
        }

        return $valueNode->value;
    }

    public function parseValue($value, array $variables = null)
    {
        if (!is_string($value)) {
            return null;
        }
        try {
            $json = json_decode($value, true);
            return $json;
        } catch (Exception $e) {
            throw new Error('Invalid JSON');
        }
    }

    public function serialize($value)
    {
        try {
            return json_encode($value);
        } catch (Exception $e) {
            throw new Error('Invalid JSON Object Value');
        }
    }
}
