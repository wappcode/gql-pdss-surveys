<?php

namespace GPDSurvey\Infrastructure\Persistence\Doctrine\Repository;

use GPDSurvey\Domain\Survey\SurveyQuestion;
use GPDSurvey\Entities\SurveyQuestion as DoctrineSurveyQuestion;

final class QuestionDoctrineRepository
{
    public function __construct(private object $entityManager)
    {
    }

    public function save(SurveyQuestion $question): void
    {
        $entity = new DoctrineSurveyQuestion();
        $entity->setTitle($question->title());
        $entity->setCode($question->code());
        $entity->setRequired($question->isRequired());
        $entity->setOther($question->isOther());
        $entity->setScore($question->score());
        $entity->setType('RADIO_LIST');

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function findById(string $id): ?SurveyQuestion
    {
        $entity = $this->entityManager->find(DoctrineSurveyQuestion::class, $id);

        if ($entity === null) {
            return null;
        }

        return new SurveyQuestion(
            (string) $entity->getId(),
            $entity->getTitle(),
            $entity->getCode(),
            (bool) $entity->getRequired(),
            (bool) $entity->getOther(),
            $entity->getScore()
        );
    }

    /**
     * @return SurveyQuestion[]
     */
    public function findAll(): array
    {
        $entities = $this->entityManager->getRepository(DoctrineSurveyQuestion::class)->findAll();

        return array_map(function ($entity): SurveyQuestion {
            return new SurveyQuestion(
                (string) $entity->getId(),
                $entity->getTitle(),
                $entity->getCode(),
                (bool) $entity->getRequired(),
                (bool) $entity->getOther(),
                $entity->getScore()
            );
        }, $entities);
    }
}
