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
    private function touch(): self
    {
        $this->updated = new \DateTimeImmutable();

        return $this;
    }
}
