<?php

namespace GPDSurvey\Domain\Entities;

use GPDSurvey\Domain\Entities\SurveyContent;
use GPDSurvey\Domain\Entities\SurveyQuestion;
use GPDSurvey\Domain\Entities\SurveyConfiguration;
use GPDSurvey\Domain\ValueObject\IntID;

class SurveyQuestionOption
{

    protected \DateTimeImmutable $created;
    protected \DateTimeImmutable $updated;


    public function __construct(
        private IntID $id,
        private string $value,
        private string $title,
        private int $order,
        private ?SurveyContent $content = null,
        private ?SurveyConfiguration $presentation = null,
        private SurveyQuestion $question
    ) {
        $this->created = new \DateTimeImmutable();
        $this->updated = new \DateTimeImmutable();
    }

    public function id(): IntID
    {
        return $this->id;
    }
    public function value(): string
    {
        return $this->value;
    }

    public function title(): string
    {
        return $this->title;
    }
    public function order(): int
    {
        return $this->order;
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

    public function presentation(): ?SurveyConfiguration
    {
        return $this->presentation;
    }

    public function question(): SurveyQuestion
    {
        return $this->question;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id()->value(),
            'value' => $this->value(),
            'title' => $this->title(),
            'order' => $this->order(),
            'content' => $this->content() !== null ? $this->content()->toArray() : null,
            'presentation' => $this->presentation() !== null ? $this->presentation()->toArray() : null,
            'question' => $this->question()->toArray(),
            'created' => $this->created()->format(\DateTimeInterface::ATOM),
            'updated' => $this->updated()->format(\DateTimeInterface::ATOM),
        ];
    }

    private function touch(): void
    {
        $this->updated = new \DateTimeImmutable();
    }
}
