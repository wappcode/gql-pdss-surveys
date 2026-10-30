<?php

namespace GPDSurvey\Domain\Survey;

final class SurveyTargetAudience
{
    private string $id;
    private string $title;
    private ?\DateTimeImmutable $starts = null;
    private ?\DateTimeImmutable $ends = null;
    private ?int $attempts = null;
    private ?string $password = null;

    public function __construct(string $id, string $title)
    {
        $this->id = $id;
        $this->title = $title;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function starts(): ?\DateTimeImmutable
    {
        return $this->starts;
    }

    public function setStarts(?\DateTimeImmutable $starts): void
    {
        $this->starts = $starts;
    }

    public function ends(): ?\DateTimeImmutable
    {
        return $this->ends;
    }

    public function setEnds(?\DateTimeImmutable $ends): void
    {
        $this->ends = $ends;
    }

    public function attempts(): ?int
    {
        return $this->attempts;
    }

    public function setAttempts(?int $attempts): void
    {
        $this->attempts = $attempts;
    }

    public function password(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }
}
