<?php

namespace GPDSurvey\Infrastructure\Doctrine\Mappers;

use GPDSurvey\Domain\Entities\SurveySection as DomainSurveySection;
use GPDSurvey\Domain\ValueObject\IntID;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveySection;

final class DoctrineSurveySectionToDomainMapper
{
    public static function fromDoctrine(DoctrineSurveySection $entity): DomainSurveySection
    {
        return (new self())->map($entity);
    }

    public function map(DoctrineSurveySection $entity): DomainSurveySection
    {
        $domain = new DomainSurveySection(
            new IntID((int) ($entity->getId() ?? 0)),
            $entity->getTitle(),
            $entity->getContent() !== null ? DoctrineSurveyContentToDomainMapper::fromDoctrine($entity->getContent()) : null,
            $entity->getItems() !== null ? $entity->getItems() : new \Doctrine\Common\Collections\ArrayCollection(),
            $entity->getOrder(),
            $entity->getHidden(),
            $entity->getPresentation() !== null ? DoctrineSurveyConfigurationToDomainMapper::fromDoctrine($entity->getPresentation()) : null,
            DoctrineSurveyToDomainMapper::fromDoctrine($entity->getSurvey())
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
