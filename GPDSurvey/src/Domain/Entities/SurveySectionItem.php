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
    private function touch(): self
    {
        $this->updated = new \DateTimeImmutable();

        return $this;
    }
}
