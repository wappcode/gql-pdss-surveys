<?php

namespace GPDSurvey\Domain\Entities;

use GPDSurvey\Domain\Entities\SurveyContent;
use GPDSurvey\Domain\Entities\SurveyConfiguration;
use GPDSurvey\Domain\Entities\Survey;
use GPDSurvey\Domain\ValueObject\IntID;

class SurveySection
{

    protected \DateTimeImmutable $created;
    protected \DateTimeImmutable $updated;

    public function __construct(
        private IntID $id,
        private string $title,
        private ?SurveyContent $content = null,
        private array $items,
        private int $order,
        private bool $hidden = false,
        private ?SurveyConfiguration $presentation = null,
        private Survey $survey
    ) {
        $this->created = new \DateTimeImmutable();
        $this->updated = new \DateTimeImmutable();
    }



    public function title(): string
    {
        return $this->title;
    }
    public function content(): ?SurveyContent
    {
        return $this->content;
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
    public function survey(): Survey
    {
        return $this->survey;
    }
    public function items(): array
    {
        return $this->items;
    }
    public function order(): int
    {
        return $this->order;
    }
    public function hidden(): bool
    {
        return $this->hidden;
    }


    public function presentation(): ?SurveyConfiguration
    {
        return $this->presentation;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id()->value(),
            'title' => $this->title(),
            'content' => $this->content() !== null ? $this->content()->toArray() : null,
            'items' => array_map(fn($item) => $item->toArray(), $this->items),
            'order' => $this->order(),
            'hidden' => $this->hidden(),
            'presentation' => $this->presentation() !== null ? $this->presentation()->toArray() : null,
            'survey' => $this->survey()->toArray(),
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
