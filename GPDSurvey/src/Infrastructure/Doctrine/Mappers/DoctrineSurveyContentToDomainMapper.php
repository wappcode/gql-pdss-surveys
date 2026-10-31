<?php

namespace GPDSurvey\Infrastructure\Doctrine\Mappers;

use GPDSurvey\Domain\Entities\SurveyConfiguration;
use GPDSurvey\Domain\Entities\SurveyContent as DomainSurveyContent;
use GPDSurvey\Domain\ValueObject\IntID;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveyContent;

final class DoctrineSurveyContentToDomainMapper
{
    public static function fromDoctrine(DoctrineSurveyContent $entity): DomainSurveyContent
    {
        return (new self())->map($entity);
    }

    public function map(DoctrineSurveyContent $entity): DomainSurveyContent
    {
        $domain = new DomainSurveyContent(
            new IntID((int) ($entity->getId() ?? 0)),
            $entity->getType(),
            $entity->getBody(),
            $entity->getPresentation() !== null ? DoctrineSurveyConfigurationToDomainMapper::fromDoctrine($entity->getPresentation()) : null
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
