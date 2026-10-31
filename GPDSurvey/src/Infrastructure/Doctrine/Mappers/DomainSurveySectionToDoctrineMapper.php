<?php

namespace GPDSurvey\Infrastructure\Doctrine\Mappers;

use GPDSurvey\Domain\Entities\SurveySection as DomainSurveySection;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveySection;

final class DomainSurveySectionToDoctrineMapper
{
    public static function fromDomain(DomainSurveySection $section): DoctrineSurveySection
    {
        return (new self())->map($section);
    }

    public function map(DomainSurveySection $section): DoctrineSurveySection
    {
        $entity = new DoctrineSurveySection();

        if ($section->id()->value() !== 0) {
            $this->setProperty($entity, 'id', $section->id()->value());
        }

        $entity
            ->setTitle($section->title())
            ->setOrder($section->order())
            ->setHidden($section->hidden())
            ->setSurvey(DomainSurveyToDoctrineMapper::fromDomain($section->survey()));

        if ($section->content() !== null) {
            $entity->setContent(DomainSurveyContentToDoctrineMapper::fromDomain($section->content()));
        }
        if ($section->presentation() !== null) {
            $entity->setPresentation(DomainSurveyConfigurationToDoctrineMapper::fromDomain($section->presentation()));
        }
        if ($section->items() !== null) {
            $entity->setItems($section->items());
        }

        $this->setProperty($entity, 'created', $section->created());
        $this->setProperty($entity, 'updated', $section->updated());

        return $entity;
    }

    private function setProperty(object $target, string $propertyName, mixed $value): void
    {
        $property = new \ReflectionProperty($target, $propertyName);
        $property->setAccessible(true);
        $property->setValue($target, $value);
    }
}
