<?php

namespace GPDSurvey\Infrastructure\Doctrine\Mappers;

use GPDSurvey\Domain\Entities\Survey as DomainSurvey;
use GPDSurvey\Domain\ValueObject\ULID;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurvey;

final class DoctrineSurveyToDomainMapper
{
    public static function fromDoctrine(DoctrineSurvey $doctrineSurvey): DomainSurvey
    {
        return (new self())->map($doctrineSurvey);
    }

    public function map(DoctrineSurvey $doctrineSurvey): DomainSurvey
    {
        $survey = new DomainSurvey(
            new ULID($doctrineSurvey->getId()),
            $doctrineSurvey->getTitle(),
            $doctrineSurvey->getActive()
        );

        $this->setProperty($survey, 'created', $doctrineSurvey->getCreated());
        $this->setProperty($survey, 'updated', $doctrineSurvey->getUpdated());

        return $survey;
    }

    private function setProperty(object $target, string $propertyName, mixed $value): void
    {
        $property = new \ReflectionProperty($target, $propertyName);
        $property->setAccessible(true);
        $property->setValue($target, $value);
    }
}
