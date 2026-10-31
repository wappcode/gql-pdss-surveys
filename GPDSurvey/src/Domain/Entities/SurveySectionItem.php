<?php

namespace GPDSurvey\Domain\Entities;

use GPDSurvey\Domain\Entities\SurveyContent;
use GPDSurvey\Domain\ValueObject\ULid;

class SurveySectionItem
{

    protected  \DateTimeImmutable $created;
    protected \DateTimeImmutable $updated;

    public function __construct(
        private ULid $id,
        private string $type,
        private int $order,
        private SurveySection $section,
        private bool $hidden = false,
        private ?SurveyConfiguration $conditions = null,
        private ?SurveyQuestion $question = null,
        private ?SurveyContent $content = null,
    ) {
        $this->created = new \DateTimeImmutable();
        $this->updated = new \DateTimeImmutable();
    }


    public function id(): ULid
    {
        return $this->id;
    }
    public function section(): SurveySection
    {
        return $this->section;
    }
    public function hidden(): bool
    {
        return $this->hidden;
    }
    public function order(): int
    {
        return $this->order;
    }
    public function type(): string
    {
        return $this->type;
    }

    public function conditions(): ?SurveyConfiguration
    {
        return $this->conditions;
    }

    public function question(): ?SurveyQuestion
    {
        return $this->question;
    }

    public function content(): ?SurveyContent
    {
        return $this->content;
    }

    public function created(): \DateTimeImmutable
    {
        return $this->created;
    }

    public function updated(): \DateTimeImmutable
    {
        return $this->updated;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id()->value(),
            'type' => $this->type(),
            'order' => $this->order(),
            'section' => $this->section()->toArray(),
            'hidden' => $this->hidden(),
            'conditions' => $this->conditions() !== null ? $this->conditions()->toArray() : null,
            'question' => $this->question() !== null ? $this->question()->toArray() : null,
            'content' => $this->content() !== null ? $this->content()->toArray() : null,
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
