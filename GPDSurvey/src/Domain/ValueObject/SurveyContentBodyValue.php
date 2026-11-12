<?php

namespace GPDSurvey\Domain\ValueObject;

class SurveyContentBodyValue
{
    private string $value;

    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new \InvalidArgumentException('Survey content value cannot be empty.');
        }
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
