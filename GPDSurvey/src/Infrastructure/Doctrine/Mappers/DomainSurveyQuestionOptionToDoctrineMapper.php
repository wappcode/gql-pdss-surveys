<?php

namespace GPDSurvey\Infrastructure\Doctrine\Mappers;

use GPDSurvey\Domain\Entities\SurveyQuestionOption as DomainSurveyQuestionOption;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveyQuestionOption;

final class DomainSurveyQuestionOptionToDoctrineMapper
{
    public static function fromDomain(DomainSurveyQuestionOption $option): DoctrineSurveyQuestionOption
    {
        return (new self())->map($option);
    }

    public function map(DomainSurveyQuestionOption $option): DoctrineSurveyQuestionOption
    {
        $entity = new DoctrineSurveyQuestionOption();

        if ($option->id()->value() !== 0) {
            $this->setProperty($entity, 'id', $option->id()->value());
        }

        $entity
            ->setValue($option->value())
            ->setTitle($option->title())
            ->setOrder($option->order())
            ->setQuestion(DomainSurveyQuestionToDoctrineMapper::fromDomain($option->question()));

        if ($option->content() !== null) {
            $entity->setContent(DomainSurveyContentToDoctrineMapper::fromDomain($option->content()));
        }
        if ($option->presentation() !== null) {
            $entity->setPresentation(DomainSurveyConfigurationToDoctrineMapper::fromDomain($option->presentation()));
        }

        $this->setProperty($entity, 'created', $option->created());
        $this->setProperty($entity, 'updated', $option->updated());

        return $entity;
    }

    private function setProperty(object $target, string $propertyName, mixed $value): void
    {
        $property = new \ReflectionProperty($target, $propertyName);
        $property->setAccessible(true);
        $property->setValue($target, $value);
    }
}
