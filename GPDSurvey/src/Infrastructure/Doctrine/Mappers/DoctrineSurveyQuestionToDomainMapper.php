<?php

namespace GPDSurvey\Infrastructure\Doctrine\Mappers;

use GPDSurvey\Domain\Entities\SurveyQuestion as DomainSurveyQuestion;
use GPDSurvey\Domain\ValueObject\ULID;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveyQuestion;

final class DoctrineSurveyQuestionToDomainMapper
{
    public static function fromDoctrine(DoctrineSurveyQuestion $entity): DomainSurveyQuestion
    {
        return (new self())->map($entity);
    }

    public function map(DoctrineSurveyQuestion $entity): DomainSurveyQuestion
    {
        $domain = new DomainSurveyQuestion(
            new ULID($entity->getId()),
            $entity->getTitle(),
            $entity->getCode(),
            $entity->getType(),
            DoctrineSurveyToDomainMapper::fromDoctrine($entity->getSurvey()),
            $entity->getRequired(),
            $entity->getOther(),
            $entity->getScore(),
            $entity->getOptions() !== null ? array_map(
                static fn($option) => DoctrineSurveyQuestionOptionToDomainMapper::fromDoctrine($option),
                $entity->getOptions()->toArray()
            ) : null,
            $entity->getHint() !== null ? DoctrineSurveyContentToDomainMapper::fromDoctrine($entity->getHint()) : null,
            $entity->getContent() !== null ? DoctrineSurveyContentToDomainMapper::fromDoctrine($entity->getContent()) : null,
            $entity->getPresentation() !== null ? DoctrineSurveyConfigurationToDomainMapper::fromDoctrine($entity->getPresentation()) : null,
            $entity->getValidators() !== null ? DoctrineSurveyConfigurationToDomainMapper::fromDoctrine($entity->getValidators()) : null,
            $entity->getAnswerScore() !== null ? DoctrineSurveyConfigurationToDomainMapper::fromDoctrine($entity->getAnswerScore()) : null,
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
