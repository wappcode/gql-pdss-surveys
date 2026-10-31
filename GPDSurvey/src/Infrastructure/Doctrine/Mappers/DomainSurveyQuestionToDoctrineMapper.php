<?php

namespace GPDSurvey\Infrastructure\Doctrine\Mappers;

use GPDSurvey\Domain\Entities\SurveyQuestion as DomainSurveyQuestion;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveyQuestion;

final class DomainSurveyQuestionToDoctrineMapper
{
    public static function fromDomain(DomainSurveyQuestion $question): DoctrineSurveyQuestion
    {
        return (new self())->map($question);
    }

    public function map(DomainSurveyQuestion $question): DoctrineSurveyQuestion
    {
        $entity = new DoctrineSurveyQuestion();

        if ($question->id()->value() !== '') {
            $this->setProperty($entity, 'id', $question->id()->value());
        }

        $entity
            ->setTitle($question->title())
            ->setCode($question->code())
            ->setType($question->type())
            ->setRequired($question->required())
            ->setOther($question->other())
            ->setScore($question->score())
            ->setSurvey(DomainSurveyToDoctrineMapper::fromDomain($question->survey()));

        if ($question->hint() !== null) {
            $entity->setHint(DomainSurveyContentToDoctrineMapper::fromDomain($question->hint()));
        }
        if ($question->content() !== null) {
            $entity->setContent(DomainSurveyContentToDoctrineMapper::fromDomain($question->content()));
        }
        if ($question->presentation() !== null) {
            $entity->setPresentation(DomainSurveyConfigurationToDoctrineMapper::fromDomain($question->presentation()));
        }
        if ($question->validators() !== null) {
            $entity->setValidators(DomainSurveyConfigurationToDoctrineMapper::fromDomain($question->validators()));
        }
        if ($question->answerScore() !== null) {
            $entity->setAnswerScore(DomainSurveyConfigurationToDoctrineMapper::fromDomain($question->answerScore()));
        }

        $this->setProperty($entity, 'created', $question->created());
        $this->setProperty($entity, 'updated', $question->updated());

        return $entity;
    }

    private function setProperty(object $target, string $propertyName, mixed $value): void
    {
        $property = new \ReflectionProperty($target, $propertyName);
        $property->setAccessible(true);
        $property->setValue($target, $value);
    }
}
