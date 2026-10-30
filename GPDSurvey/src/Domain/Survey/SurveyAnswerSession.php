<?php

namespace GPDSurvey\Domain\Survey;

final class SurveyAnswerSession
{
    public function __construct(
        private string $id,
        private string $targetAudienceId,
        private string $surveyId,
        private ?string $name = null,
        private ?string $username = null,
        private ?string $password = null,
        private ?string $ownerCode = null,
        private ?float $score = null,
        private bool $completed = false,
        private ?float $scorePercent = null
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function targetAudienceId(): string
    {
        return $this->targetAudienceId;
    }

    public function surveyId(): string
    {
        return $this->surveyId;
    }

    public function name(): ?string
    {
        return $this->name;
    }

    public function username(): ?string
    {
        return $this->username;
    }

    public function password(): ?string
    {
        return $this->password;
    }

    public function ownerCode(): ?string
    {
        return $this->ownerCode;
    }

    public function score(): ?float
    {
        return $this->score;
    }

    public function isCompleted(): bool
    {
        return $this->completed;
    }

    public function scorePercent(): ?float
    {
        return $this->scorePercent;
    }
}
