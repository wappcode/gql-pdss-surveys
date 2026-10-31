<?php

namespace GPDSurvey\Infrastructure\Doctrine\Mappers;

use GPDSurvey\Domain\Entities\SurveySectionItem as DomainSurveySectionItem;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveySectionItem;

final class DomainSurveySectionItemToDoctrineMapper
{
    public static function fromDomain(DomainSurveySectionItem $item): DoctrineSurveySectionItem
    {
        return (new self())->map($item);
    }

    public function map(DomainSurveySectionItem $item): DoctrineSurveySectionItem
    {
        $entity = new DoctrineSurveySectionItem();

        if ($item->id()->value() !== '') {
            $this->setProperty($entity, 'id', $item->id()->value());
        }

        $entity
            ->setType($item->type())
            ->setOrder($item->order())
            ->setHidden($item->hidden())
            ->setSection(DomainSurveySectionToDoctrineMapper::fromDomain($item->section()));

        if ($item->conditions() !== null) {
            $entity->setConditions(DomainSurveyConfigurationToDoctrineMapper::fromDomain($item->conditions()));
        }
        if ($item->question() !== null) {
            $entity->setQuestion(DomainSurveyQuestionToDoctrineMapper::fromDomain($item->question()));
        }
        if ($item->content() !== null) {
            $entity->setContent(DomainSurveyContentToDoctrineMapper::fromDomain($item->content()));
        }

        $this->setProperty($entity, 'created', $item->created());
        $this->setProperty($entity, 'updated', $item->updated());

        return $entity;
    }

    private function setProperty(object $target, string $propertyName, mixed $value): void
    {
        $property = new \ReflectionProperty($target, $propertyName);
        $property->setAccessible(true);
        $property->setValue($target, $value);
    }
}
