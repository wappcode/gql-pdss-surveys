<?php

namespace GPDSurvey\Domain\Entities;

use DateTimeImmutable;
use DateTimeInterface;
use GPDSurvey\Domain\Entities\Survey;
use GPDSurvey\Domain\Entities\SurveyContent;
use GPDSurvey\Domain\Entities\SurveyConfiguration;
use GPDSurvey\Domain\ValueObject\ULid;

class SurveyTargetAudience
{

    protected  DateTimeImmutable $created;
    protected DateTimeImmutable $updated;

    private function __construct(
        private ULid $id,
        private string $title,
        private Survey $survey,
        private ?DateTimeInterface $starts = null,
        private ?DateTimeInterface $ends = null,
        private ?SurveyContent $welcome = null,
        private ?SurveyContent $farewell = null,
        private ?int $attempts = null,
        private ?SurveyConfiguration $presentation = null,
        private ?string $password = null
    ) {
        $this->created = new DateTimeImmutable();
        $this->updated = new DateTimeImmutable();
    }

    //TODO agregar seguridad para consultas de targetAudience no debe retornar información si tiene asignado un password


    public function id(): ULid
    {
        return $this->id;
    }
    public function title(): string
    {
        return $this->title;
    }
    public function starts(): ?DateTimeInterface
    {
        return $this->starts;
    }
    public function ends(): ?DateTimeInterface
    {
        return $this->ends;
    }
    public function welcome(): ?SurveyContent
    {
        return $this->welcome;
    }

    public function farewell(): ?SurveyContent
    {
        return $this->farewell;
    }
    public function attempts(): ?int
    {
        return $this->attempts;
    }

    public function survey(): Survey
    {
        return $this->survey;
    }
    public function presentation(): ?SurveyConfiguration
    {
        return $this->presentation;
    }

    public function password(): ?string
    {
        return $this->password;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id()->value(),
            'title' => $this->title(),
            'survey' => $this->survey()->toArray(),
            'starts' => $this->starts() !== null ? $this->starts()->format(\DateTimeInterface::ATOM) : null,
            'ends' => $this->ends() !== null ? $this->ends()->format(\DateTimeInterface::ATOM) : null,
            'welcome' => $this->welcome() !== null ? $this->welcome()->toArray() : null,
            'farewell' => $this->farewell() !== null ? $this->farewell()->toArray() : null,
            'attempts' => $this->attempts(),
            'presentation' => $this->presentation() !== null ? $this->presentation()->toArray() : null,
            'password' => $this->password(),
            'created' => $this->created->format(\DateTimeInterface::ATOM),
            'updated' => $this->updated->format(\DateTimeInterface::ATOM),
        ];
    }

    private function touch(): self
    {
        $this->updated = new \DateTimeImmutable();

        return $this;
    }
}
