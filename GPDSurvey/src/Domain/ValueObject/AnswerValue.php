<?php

namespace GPDSurvey\Domain\ValueObject;

class AnswerValue
{
    private ?string $value;

    public function __construct(?string $value = null)
    {
        $this->changeValue($value);
    }

    public function value(): ?string
    {
        return $this->value;
    }

    public function changeValue(?string $value)
    {
        if ($value !== null && trim($value) === '') {
            $value = null;
        }
        $this->value = $value;

        return $this;
    }
}
