<?php

namespace GPDSurvey\Domain\Entities;

use GPDSurvey\Domain\ValueObject\IntID;
use GPDSurvey\Domain\Entities\SurveyConfiguration;

class SurveyContent
{
    protected \DateTimeImmutable $created;
    protected \DateTimeImmutable $updated;

    public function __construct(
        private IntID $id,
        private string $type,
        private ?string $body = null,
        private ?SurveyConfiguration $presentation = null,
    ) {
        $this->created = new \DateTimeImmutable();
        $this->updated = new \DateTimeImmutable();
    }
    public function id(): IntID
    {
        return $this->id;
    }
    public function created(): \DateTimeImmutable
    {
        return $this->created;
    }

    public function updated(): \DateTimeImmutable
    {
        return $this->updated;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function body(): ?string
    {
        return $this->body;
    }

    public function presentation(): ?SurveyConfiguration
    {
        return $this->presentation;
    }
    private function touch(): self
    {
        $this->updated = new \DateTimeImmutable();

        return $this;
    }
}
