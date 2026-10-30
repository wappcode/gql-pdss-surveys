<?php

namespace GPDSurvey\Infrastructure\Persistence\Doctrine\Repository;

use GPDSurvey\Domain\Survey\SurveyTargetAudience;
use GPDSurvey\Entities\SurveyTargetAudience as DoctrineSurveyTargetAudience;

final class TargetAudienceDoctrineRepository
{
    public function __construct(private object $entityManager)
    {
    }

    public function save(SurveyTargetAudience $targetAudience): void
    {
        $entity = new DoctrineSurveyTargetAudience();
        $entity->setTitle($targetAudience->title());
        $entity->setAttempts($targetAudience->attempts());
        $entity->setPassword($targetAudience->password());

        if ($targetAudience->starts() instanceof \DateTimeImmutable) {
            $entity->setStarts($targetAudience->starts());
        }

        if ($targetAudience->ends() instanceof \DateTimeImmutable) {
            $entity->setEnds($targetAudience->ends());
        }

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    /**
     * @return SurveyTargetAudience[]
     */
    public function findAll(): array
    {
        $entities = $this->entityManager->getRepository(DoctrineSurveyTargetAudience::class)->findAll();

        return array_map(function ($entity): SurveyTargetAudience {
            $targetAudience = new SurveyTargetAudience((string) $entity->getId(), $entity->getTitle());
            $targetAudience->setStarts($entity->getStarts() ? new \DateTimeImmutable($entity->getStarts()->format('c')) : null);
            $targetAudience->setEnds($entity->getEnds() ? new \DateTimeImmutable($entity->getEnds()->format('c')) : null);
            $targetAudience->setAttempts($entity->getAttempts());
            $targetAudience->setPassword($entity->getPassword());

            return $targetAudience;
        }, $entities);
    }
}
