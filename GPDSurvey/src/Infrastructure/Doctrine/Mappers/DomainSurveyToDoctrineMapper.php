<?php

namespace GPDSurvey\Infrastructure\Doctrine\Mappers;

use GPDSurvey\Domain\Entities\Survey as DomainSurvey;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurvey;

final class DomainSurveyToDoctrineMapper
{
    public static function fromDomain(DomainSurvey $survey): DoctrineSurvey
    {
        return (new self())->map($survey);
    }

    public function map(DomainSurvey $survey): DoctrineSurvey
    {
        $doctrineSurvey = new DoctrineSurvey();

        if ($survey->id()->value() !== '') {
            $reflection = new \ReflectionProperty(DoctrineSurvey::class, 'id');
            $reflection->setAccessible(true);
            $reflection->setValue($doctrineSurvey, $survey->id()->value());
        }

        $doctrineSurvey
            ->setTitle($survey->title())
            ->setActive($survey->isActive());

        $this->setProperty($doctrineSurvey, 'created', $survey->created());
        $this->setProperty($doctrineSurvey, 'updated', $survey->updated());

        return $doctrineSurvey;
    }

    private function setProperty(object $target, string $propertyName, mixed $value): void
    {
        $property = new \ReflectionProperty($target, $propertyName);
        $property->setAccessible(true);
        $property->setValue($target, $value);
    }
}
