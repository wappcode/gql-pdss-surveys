<?php

namespace GPDSurvey\Domain\Entities;

use GPDSurvey\Domain\ValueObject\ULID;

class SurveyAnswerSession
{
    protected  \DateTimeImmutable $created;
    protected \DateTimeImmutable $updated;

    public function __construct(
        private ULID $id,
        private string $name,
        private SurveyTargetAudience $targetAudience,
        private Survey $survey,
        private ?string $username = null,
        private ?string $password = null,
        private ?string $ownerCode = null,
        private ?float $score = null,
        private ?float $scorePercent = null,
        private bool $completed = false,
    ) {
        $this->created = new \DateTimeImmutable();
        $this->updated = new \DateTimeImmutable();
    }

    public function id(): ULID
    {
        return $this->id;
    }

    public function survey(): Survey
    {
        return $this->survey;
    }
    public function name(): string
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

    public function scorePercent(): ?float
    {
        return $this->scorePercent;
    }
    public function created(): \DateTimeImmutable
    {
        return $this->created;
    }

    public function updated(): \DateTimeImmutable
    {
        return $this->updated;
    }

    public function targetAudience(): SurveyTargetAudience
    {
        return $this->targetAudience;
    }
    public function isCompleted(): bool
    {
        return $this->completed;
    }
    public function complete()
    {
        $this->completed = true;
        $this->touch();
    }

    private function touch(): self
    {
        $this->updated = new \DateTimeImmutable();

        return $this;
    }
}
