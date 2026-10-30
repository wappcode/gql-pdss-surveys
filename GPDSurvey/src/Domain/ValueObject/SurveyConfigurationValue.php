<?php


namespace GPDSurvey\Domain\ValueObject;

class SurveyConfigurationValue
{
    private array $value;

    public function __construct(array $value)
    {
        if (empty($value)) {
            throw new \InvalidArgumentException('Survey configuration value cannot be empty.');
        }
        if (!is_array($value)) {
            throw new \InvalidArgumentException('Survey configuration value must be an array.');
        }
        $this->value = $value;
    }

    public function value(): array
    {
        return $this->value;
    }
}
