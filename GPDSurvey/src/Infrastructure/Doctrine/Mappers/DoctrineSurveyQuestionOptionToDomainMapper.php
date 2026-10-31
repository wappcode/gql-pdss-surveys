<?php

namespace GPDSurvey\Infrastructure\Doctrine\Mappers;

use GPDSurvey\Domain\Entities\SurveyQuestionOption as DomainSurveyQuestionOption;
use GPDSurvey\Domain\ValueObject\IntID;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveyQuestionOption;

final class DoctrineSurveyQuestionOptionToDomainMapper
{
    public static function fromDoctrine(DoctrineSurveyQuestionOption $entity): DomainSurveyQuestionOption
    {
        return (new self())->map($entity);
    }

    public function map(DoctrineSurveyQuestionOption $entity): DomainSurveyQuestionOption
    {
        $domain = new DomainSurveyQuestionOption(
            new IntID((int) ($entity->getId() ?? 0)),
            $entity->getValue(),
            $entity->getTitle(),
            $entity->getOrder(),
            $entity->getContent() !== null ? DoctrineSurveyContentToDomainMapper::fromDoctrine($entity->getContent()) : null,
            $entity->getPresentation() !== null ? DoctrineSurveyConfigurationToDomainMapper::fromDoctrine($entity->getPresentation()) : null,
            DoctrineSurveyQuestionToDomainMapper::fromDoctrine($entity->getQuestion())
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
