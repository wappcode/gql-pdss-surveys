<?php

namespace GPDSurvey\Domain\Survey;

final class SurveyQuestion
{
    public function __construct(
        private string $id,
        private string $title,
        private string $code,
        private bool $required,
        private bool $other,
        private ?float $score = null
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function isRequired(): bool
    {
        return $this->required;
    }

    public function isOther(): bool
    {
        return $this->other;
    }

    public function score(): ?float
    {
        return $this->score;
    }
}
