<?php

namespace GPDSurvey\Infrastructure\Doctrine\Mappers;

use GPDSurvey\Domain\Entities\SurveyTargetAudience as DomainSurveyTargetAudience;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveyTargetAudience;

final class DomainSurveyTargetAudienceToDoctrineMapper
{
    public static function fromDomain(DomainSurveyTargetAudience $targetAudience): DoctrineSurveyTargetAudience
    {
        return (new self())->map($targetAudience);
    }

    public function map(DomainSurveyTargetAudience $targetAudience): DoctrineSurveyTargetAudience
    {
        $entity = new DoctrineSurveyTargetAudience();

        if ($targetAudience->id()->value() !== '') {
            $this->setProperty($entity, 'id', $targetAudience->id()->value());
        }

        $entity
            ->setTitle($targetAudience->title())
            ->setSurvey(DomainSurveyToDoctrineMapper::fromDomain($targetAudience->survey()))
            ->setAttempts($targetAudience->attempts())
            ->setPassword($targetAudience->password());

        if ($targetAudience->starts() !== null) {
            $entity->setStarts($targetAudience->starts());
        }
        if ($targetAudience->ends() !== null) {
            $entity->setEnds($targetAudience->ends());
        }
        if ($targetAudience->welcome() !== null) {
            $entity->setWelcome(DomainSurveyContentToDoctrineMapper::fromDomain($targetAudience->welcome()));
        }
        if ($targetAudience->farewell() !== null) {
            $entity->setFarewell(DomainSurveyContentToDoctrineMapper::fromDomain($targetAudience->farewell()));
        }
        if ($targetAudience->presentation() !== null) {
            $entity->setPresentation(DomainSurveyConfigurationToDoctrineMapper::fromDomain($targetAudience->presentation()));
        }

        $this->setProperty($entity, 'created', $targetAudience->created());
        $this->setProperty($entity, 'updated', $targetAudience->updated());

        return $entity;
    }

    private function setProperty(object $target, string $propertyName, mixed $value): void
    {
        $property = new \ReflectionProperty($target, $propertyName);
        $property->setAccessible(true);
        $property->setValue($target, $value);
    }
}
