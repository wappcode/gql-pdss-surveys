<?php

namespace GPDSurvey\Infrastructure\Persistence\Doctrine\Repository;

use GPDSurvey\Domain\Survey\SurveyAnswer;
use GPDSurvey\Entities\SurveyAnswer as DoctrineSurveyAnswer;

final class AnswerDoctrineRepository
{
    public function __construct(private object $entityManager)
    {
    }

    public function save(SurveyAnswer $answer): void
    {
        $entity = new DoctrineSurveyAnswer();
        $entity->setValue($answer->value());
        $entity->setScore($answer->score());
        $entity->setScorePercent($answer->scorePercent());

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function findById(string $id): ?SurveyAnswer
    {
        $entity = $this->entityManager->find(DoctrineSurveyAnswer::class, $id);

        if ($entity === null) {
            return null;
        }

        return new SurveyAnswer(
            (string) $entity->getId(),
            (string) $entity->getQuestion()->getId(),
            (string) $entity->getSession()->getId(),
            $entity->getValue(),
            $entity->getScore(),
            $entity->getScorePercent()
        );
    }

    /**
     * @return SurveyAnswer[]
     */
    public function findAll(): array
    {
        $entities = $this->entityManager->getRepository(DoctrineSurveyAnswer::class)->findAll();

        return array_map(function ($entity): SurveyAnswer {
            return new SurveyAnswer(
                (string) $entity->getId(),
                (string) $entity->getQuestion()->getId(),
                (string) $entity->getSession()->getId(),
                $entity->getValue(),
                $entity->getScore(),
                $entity->getScorePercent()
            );
        }, $entities);
    }
}
