<?php

namespace GPDSurvey\Infrastructure\Doctrine\Mappers;

use GPDSurvey\Domain\Entities\SurveyAnswer as DomainSurveyAnswer;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveyAnswer;

final class DomainSurveyAnswerToDoctrineMapper
{
    public static function fromDomain(DomainSurveyAnswer $answer): DoctrineSurveyAnswer
    {
        return (new self())->map($answer);
    }

    public function map(DomainSurveyAnswer $answer): DoctrineSurveyAnswer
    {
        $entity = new DoctrineSurveyAnswer();

        if ($answer->value() !== null) {
            $this->setProperty($entity, 'id', $answer->id()->value());
        }

        $entity
            ->setValue($answer->value()?->value())
            ->setScore($answer->score())
            ->setScorePercent($answer->scorePercent());

        if ($answer->question() !== null) {
            $entity->setQuestion(DomainSurveyQuestionToDoctrineMapper::fromDomain($answer->question()));
        }
        if ($answer->session() !== null) {
            $entity->setSession(DomainSurveyAnswerSessionToDoctrineMapper::fromDomain($answer->session()));
        }

        $this->setProperty($entity, 'created', $answer->created());
        $this->setProperty($entity, 'updated', $answer->updated());

        return $entity;
    }

    private function setProperty(object $target, string $propertyName, mixed $value): void
    {
        $property = new \ReflectionProperty($target, $propertyName);
        $property->setAccessible(true);
        $property->setValue($target, $value);
    }
}
