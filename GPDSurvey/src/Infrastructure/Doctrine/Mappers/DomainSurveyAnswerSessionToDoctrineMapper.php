<?php

namespace GPDSurvey\Infrastructure\Doctrine\Mappers;

use GPDSurvey\Domain\Entities\SurveyAnswerSession as DomainSurveyAnswerSession;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveyAnswerSession;

final class DomainSurveyAnswerSessionToDoctrineMapper
{
    public static function fromDomain(DomainSurveyAnswerSession $session): DoctrineSurveyAnswerSession
    {
        return (new self())->map($session);
    }

    public function map(DomainSurveyAnswerSession $session): DoctrineSurveyAnswerSession
    {
        $entity = new DoctrineSurveyAnswerSession();

        if ($session->id()->value() !== '') {
            $this->setProperty($entity, 'id', $session->id()->value());
        }

        $entity
            ->setName($session->name())
            ->setUsername($session->username())
            ->setPassword($session->password())
            ->setOwnerCode($session->ownerCode())
            ->setScore($session->score())
            ->setScorePercent($session->scorePercent())
            ->setTargetAudience(DomainSurveyTargetAudienceToDoctrineMapper::fromDomain($session->targetAudience()))
            ->setSurvey(DomainSurveyToDoctrineMapper::fromDomain($session->survey()))
            ->setCompleted($session->isCompleted());

        $this->setProperty($entity, 'created', $session->created());
        $this->setProperty($entity, 'updated', $session->updated());

        return $entity;
    }

    private function setProperty(object $target, string $propertyName, mixed $value): void
    {
        $property = new \ReflectionProperty($target, $propertyName);
        $property->setAccessible(true);
        $property->setValue($target, $value);
    }
}
