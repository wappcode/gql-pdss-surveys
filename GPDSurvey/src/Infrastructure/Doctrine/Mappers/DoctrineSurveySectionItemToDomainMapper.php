<?php

namespace GPDSurvey\Infrastructure\Doctrine\Mappers;

use GPDSurvey\Domain\Entities\SurveySectionItem as DomainSurveySectionItem;
use GPDSurvey\Domain\ValueObject\ULID;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveySectionItem;

final class DoctrineSurveySectionItemToDomainMapper
{
    public static function fromDoctrine(DoctrineSurveySectionItem $entity): DomainSurveySectionItem
    {
        return (new self())->map($entity);
    }

    public function map(DoctrineSurveySectionItem $entity): DomainSurveySectionItem
    {
        $domain = new DomainSurveySectionItem(
            new ULID($entity->getId()),
            $entity->getType(),
            $entity->getOrder(),
            DoctrineSurveySectionToDomainMapper::fromDoctrine($entity->getSection()),
            $entity->getHidden(),
            $entity->getConditions() !== null ? DoctrineSurveyConfigurationToDomainMapper::fromDoctrine($entity->getConditions()) : null,
            $entity->getQuestion() !== null ? DoctrineSurveyQuestionToDomainMapper::fromDoctrine($entity->getQuestion()) : null,
            $entity->getContent() !== null ? DoctrineSurveyContentToDomainMapper::fromDoctrine($entity->getContent()) : null,
        );

        $this->setProperty($domain, 'created', $entity->getCreated());
        $this->setProperty($domain, 'updated', $entity->getUpdated());

        return $domain;
    }

    private function setProperty(object $target, string $propertyName, mixed $value): void
    {
        $property = new \ReflectionProperty($target, $propertyName);
        $property->setAccessible(true);
        $property->setValue($target, $value);
    }
}
