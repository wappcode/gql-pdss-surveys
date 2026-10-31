<?php

namespace GPDSurvey\Infrastructure\Doctrine\Mappers;

use GPDSurvey\Domain\Entities\SurveyConfiguration as DomainSurveyConfiguration;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveyConfiguration;

final class DomainSurveyConfigurationToDoctrineMapper
{
    public static function fromDomain(DomainSurveyConfiguration $configuration): DoctrineSurveyConfiguration
    {
        return (new self())->map($configuration);
    }

    public function map(DomainSurveyConfiguration $configuration): DoctrineSurveyConfiguration
    {
        $entity = new DoctrineSurveyConfiguration();

        if ($configuration->id()->value() !== 0) {
            $this->setProperty($entity, 'id', $configuration->id()->value());
        }

        $entity
            ->setValue($configuration->value()->value())
            ->setType($configuration->type());

        $this->setProperty($entity, 'created', $configuration->created());
        $this->setProperty($entity, 'updated', $configuration->updated());

        return $entity;
    }

    private function setProperty(object $target, string $propertyName, mixed $value): void
    {
        $property = new \ReflectionProperty($target, $propertyName);
        $property->setAccessible(true);
        $property->setValue($target, $value);
    }
}
