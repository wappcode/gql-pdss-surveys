<?php

namespace GPDSurvey\Infrastructure\Doctrine\Mappers;

use GPDSurvey\Domain\Entities\SurveyTargetAudience as DomainSurveyTargetAudience;
use GPDSurvey\Domain\ValueObject\ULID;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveyTargetAudience;

final class DoctrineSurveyTargetAudienceToDomainMapper
{
    public static function fromDoctrine(DoctrineSurveyTargetAudience $entity): DomainSurveyTargetAudience
    {
        return (new self())->map($entity);
    }

    public function map(DoctrineSurveyTargetAudience $entity): DomainSurveyTargetAudience
    {
        $domain = new DomainSurveyTargetAudience(
            new ULID($entity->getId()),
            $entity->getTitle(),
            DoctrineSurveyToDomainMapper::fromDoctrine($entity->getSurvey()),
            $entity->getStarts(),
            $entity->getEnds(),
            $entity->getWelcome() !== null ? DoctrineSurveyContentToDomainMapper::fromDoctrine($entity->getWelcome()) : null,
            $entity->getFarewell() !== null ? DoctrineSurveyContentToDomainMapper::fromDoctrine($entity->getFarewell()) : null,
            $entity->getAttempts(),
            $entity->getPresentation() !== null ? DoctrineSurveyConfigurationToDomainMapper::fromDoctrine($entity->getPresentation()) : null,
            $entity->getPassword()
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
