<?php

namespace GPDSurvey\Domain\Entities;

use GPDSurvey\Domain\ValueObject\ULID;

class Survey
{

    protected  \DateTimeImmutable $created;
    protected \DateTimeImmutable $updated;
    public function __construct(private ULID $id, private string $title, private bool $active = true)
    {
        $this->created = new \DateTimeImmutable();
        $this->updated = new \DateTimeImmutable();
        $this->active = $active;
    }

    public function id(): ULID
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }
    public function created(): \DateTimeImmutable
    {
        return $this->created;
    }

    public function updated(): \DateTimeImmutable
    {
        return $this->updated;
    }


    public function changeTitle(string $title): self
    {
        $this->title = $title;
        $this->touch();
        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function activate(): self
    {
        $this->active = true;
        $this->touch();

        return $this;
    }
    public function deactivate(): self
    {
        $this->active = false;
        $this->touch();

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id()->value(),
            'title' => $this->title(),
            'active' => $this->isActive(),
            'created' => $this->created()->format(\DateTimeInterface::ATOM),
            'updated' => $this->updated()->format(\DateTimeInterface::ATOM),
        ];
    }

    private function touch(): self
    {
        $this->updated = new \DateTimeImmutable();

        return $this;
    }
}
