<?php

namespace GPDSurvey\Infrastructure\Doctrine\Mappers;

use GPDSurvey\Domain\Entities\SurveyContent as DomainSurveyContent;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveyContent;

final class DomainSurveyContentToDoctrineMapper
{
    public static function fromDomain(DomainSurveyContent $content): DoctrineSurveyContent
    {
        return (new self())->map($content);
    }

    public function map(DomainSurveyContent $content): DoctrineSurveyContent
    {
        $entity = new DoctrineSurveyContent();

        if ($content->id()->value() !== 0) {
            $this->setProperty($entity, 'id', $content->id()->value());
        }

        $entity
            ->setType($content->type())
            ->setBody($content->body());

        if ($content->presentation() !== null) {
            $entity->setPresentation(DomainSurveyConfigurationToDoctrineMapper::fromDomain($content->presentation()));
        }

        $this->setProperty($entity, 'created', $content->created());
        $this->setProperty($entity, 'updated', $content->updated());

        return $entity;
    }

    private function setProperty(object $target, string $propertyName, mixed $value): void
    {
        $property = new \ReflectionProperty($target, $propertyName);
        $property->setAccessible(true);
        $property->setValue($target, $value);
    }
}
