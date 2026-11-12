<?php

namespace GPDSurvey\Domain\Entities;

use GPDSurvey\Domain\ValueObject\IntID;
use GPDSurvey\Domain\Entities\SurveyConfiguration;
use GPDSurvey\Domain\Model\SurveyContentType;
use GPDSurvey\Domain\ValueObject\SurveyContentBodyValue;

class SurveyContent
{

    protected \DateTimeImmutable $created;
    protected \DateTimeImmutable $updated;

    public function __construct(
        private IntID $id,
        private SurveyContentType $type,
        private ?SurveyContentBodyValue $body = null,
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

    public function type(): SurveyContentType
    {
        return $this->type;
    }

    public function body(): ?SurveyContentBodyValue
    {
        return $this->body;
    }

    public function presentation(): ?SurveyConfiguration
    {
        return $this->presentation;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id()->value(),
            'type' => $this->type()->getValue(),
            'body' => $this->body() !== null ? $this->body()->getValue() : null,
            'presentation' => $this->presentation() !== null ? $this->presentation()->toArray() : null,
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
