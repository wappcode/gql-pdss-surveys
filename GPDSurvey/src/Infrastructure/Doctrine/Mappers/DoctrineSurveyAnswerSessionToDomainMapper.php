<?php

namespace GPDSurvey\Infrastructure\Doctrine\Mappers;

use GPDSurvey\Domain\Entities\SurveyAnswerSession as DomainSurveyAnswerSession;
use GPDSurvey\Domain\ValueObject\ULID;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveyAnswerSession;

final class DoctrineSurveyAnswerSessionToDomainMapper
{
    public static function fromDoctrine(DoctrineSurveyAnswerSession $entity): DomainSurveyAnswerSession
    {
        return (new self())->map($entity);
    }

    public function map(DoctrineSurveyAnswerSession $entity): DomainSurveyAnswerSession
    {
        $domain = new DomainSurveyAnswerSession(
            new ULID($entity->getId()),
            $entity->getName() ?? '',
            DoctrineSurveyTargetAudienceToDomainMapper::fromDoctrine($entity->getTargetAudience()),
            DoctrineSurveyToDomainMapper::fromDoctrine($entity->getSurvey()),
            $entity->getUsername(),
            $entity->getPassword(),
            $entity->getOwnerCode(),
            $entity->getScore(),
            $entity->getScorePercent(),
            $entity->getCompleted()
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
