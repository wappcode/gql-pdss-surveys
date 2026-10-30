<?php

namespace GPDSurvey\Domain\Survey;

final class SurveyAnswer
{
    public function __construct(
        private string $id,
        private string $questionId,
        private string $sessionId,
        private ?string $value = null,
        private ?float $score = null,
        private ?float $scorePercent = null
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function questionId(): string
    {
        return $this->questionId;
    }

    public function sessionId(): string
    {
        return $this->sessionId;
    }

    public function value(): ?string
    {
        return $this->value;
    }

    public function score(): ?float
    {
        return $this->score;
    }

    public function scorePercent(): ?float
    {
        return $this->scorePercent;
    }
}
