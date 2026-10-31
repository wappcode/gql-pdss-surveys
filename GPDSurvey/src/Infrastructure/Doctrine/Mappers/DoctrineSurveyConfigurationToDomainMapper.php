<?php

namespace GPDSurvey\Infrastructure\Doctrine\Mappers;

use GPDSurvey\Domain\Entities\SurveyConfiguration as DomainSurveyConfiguration;
use GPDSurvey\Domain\ValueObject\IntID;
use GPDSurvey\Domain\ValueObject\SurveyConfigurationValue;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveyConfiguration;

final class DoctrineSurveyConfigurationToDomainMapper
{
    public static function fromDoctrine(DoctrineSurveyConfiguration $entity): DomainSurveyConfiguration
    {
        return (new self())->map($entity);
    }

    public function map(DoctrineSurveyConfiguration $entity): DomainSurveyConfiguration
    {
        $domain = new DomainSurveyConfiguration(
            new IntID((int) ($entity->getId() ?? 0)),
            new SurveyConfigurationValue($entity->getValue()),
            $entity->getType()
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
