<?php

namespace GPDSurvey\Infrastructure\Persistence\Doctrine\Repository;

use GPDSurvey\Domain\Survey\SurveyAnswerSession;
use GPDSurvey\Entities\SurveyAnswerSession as DoctrineSurveyAnswerSession;

final class AnswerSessionDoctrineRepository
{
    public function __construct(private object $entityManager)
    {
    }

    public function save(SurveyAnswerSession $session): void
    {
        $entity = new DoctrineSurveyAnswerSession();
        $entity->setName($session->name());
        $entity->setUsername($session->username());
        $entity->setPassword($session->password());
        $entity->setOwnerCode($session->ownerCode());
        $entity->setScore($session->score());
        $entity->setCompleted($session->isCompleted());
        $entity->setScorePercent($session->scorePercent());

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function findById(string $id): ?SurveyAnswerSession
    {
        $entity = $this->entityManager->find(DoctrineSurveyAnswerSession::class, $id);

        if ($entity === null) {
            return null;
        }

        return new SurveyAnswerSession(
            (string) $entity->getId(),
            (string) $entity->getTargetAudience()->getId(),
            (string) $entity->getSurvey()->getId(),
            $entity->getName(),
            $entity->getUsername(),
            $entity->getPassword(),
            $entity->getOwnerCode(),
            $entity->getScore(),
            (bool) $entity->getCompleted(),
            $entity->getScorePercent()
        );
    }

    /**
     * @return SurveyAnswerSession[]
     */
    public function findAll(): array
    {
        $entities = $this->entityManager->getRepository(DoctrineSurveyAnswerSession::class)->findAll();

        return array_map(function ($entity): SurveyAnswerSession {
            return new SurveyAnswerSession(
                (string) $entity->getId(),
                (string) $entity->getTargetAudience()->getId(),
                (string) $entity->getSurvey()->getId(),
                $entity->getName(),
                $entity->getUsername(),
                $entity->getPassword(),
                $entity->getOwnerCode(),
                $entity->getScore(),
                (bool) $entity->getCompleted(),
                $entity->getScorePercent()
            );
        }, $entities);
    }
}
