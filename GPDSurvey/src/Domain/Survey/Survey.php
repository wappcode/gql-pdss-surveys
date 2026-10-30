<?php

namespace GPDSurvey\Domain\Survey;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Survey
{
    private SurveyId $id;
    private string $title;
    private SurveyStatus $status;
    private DateTimeImmutable $created;
    private DateTimeImmutable $updated;
    private Collection $targetAudiences;
    private Collection $questions;
    private Collection $sections;

    public function __construct(string $title, bool $active = true, ?SurveyId $id = null)
    {
        $this->id = $id ?? SurveyId::generate();
        $this->title = $title;
        $this->status = $active ? SurveyStatus::ACTIVE : SurveyStatus::DRAFT;
        $this->created = new DateTimeImmutable();
        $this->updated = new DateTimeImmutable();
        $this->targetAudiences = new ArrayCollection();
        $this->questions = new ArrayCollection();
        $this->sections = new ArrayCollection();
    }

    public function getId(): SurveyId
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
        $this->updated = new DateTimeImmutable();
    }

    public function isActive(): bool
    {
        return $this->status === SurveyStatus::ACTIVE;
    }

    public function setActive(bool $active): void
    {
        $this->status = $active ? SurveyStatus::ACTIVE : SurveyStatus::DRAFT;
        $this->updated = new DateTimeImmutable();
    }

    public function getStatus(): SurveyStatus
    {
        return $this->status;
    }

    public function getCreated(): DateTimeImmutable
    {
        return $this->created;
    }

    public function getUpdated(): DateTimeImmutable
    {
        return $this->updated;
    }

    public function getTargetAudiences(): Collection
    {
        return $this->targetAudiences;
    }

    public function setTargetAudiences(Collection $targetAudiences): void
    {
        $this->targetAudiences = $targetAudiences;
    }

    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function setQuestions(Collection $questions): void
    {
        $this->questions = $questions;
    }

    public function getSections(): Collection
    {
        return $this->sections;
    }

    public function setSections(Collection $sections): void
    {
        $this->sections = $sections;
    }
}
