<?php

namespace GPDSurvey\Infrastructure\Doctrine\Mappers;

use GPDSurvey\Domain\Entities\SurveyAnswer as DomainSurveyAnswer;
use GPDSurvey\Domain\ValueObject\AnswerValue;
use GPDSurvey\Domain\ValueObject\IntID;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveyAnswer;

final class DoctrineSurveyAnswerToDomainMapper
{
    public static function fromDoctrine(DoctrineSurveyAnswer $entity): DomainSurveyAnswer
    {
        return (new self())->map($entity);
    }

    public function map(DoctrineSurveyAnswer $entity): DomainSurveyAnswer
    {
        $domain = new DomainSurveyAnswer(
            new IntID((int) ($entity->getId() ?? 0)),
            new AnswerValue($entity->getValue()),
            $entity->getScore(),
            $entity->getScorePercent(),
            $entity->getQuestion() !== null ? DoctrineSurveyQuestionToDomainMapper::fromDoctrine($entity->getQuestion()) : null,
            $entity->getSession() !== null ? DoctrineSurveyAnswerSessionToDomainMapper::fromDoctrine($entity->getSession()) : null
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
