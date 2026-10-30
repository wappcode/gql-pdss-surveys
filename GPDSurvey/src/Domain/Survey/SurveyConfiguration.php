<?php

namespace GPDSurvey\Domain\Survey;

final class SurveyConfiguration
{
    public function __construct(
        private string $id,
        private string $value,
        private string $type
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function type(): string
    {
        return $this->type;
    }
}
