<?php

namespace GPDSurvey\Infrastructure\Persistence\Doctrine\Repository;

use GPDSurvey\Domain\Survey\SurveyQuestionOption;
use GPDSurvey\Entities\SurveyQuestionOption as DoctrineSurveyQuestionOption;

final class QuestionOptionDoctrineRepository
{
    public function __construct(private object $entityManager)
    {
    }

    public function save(SurveyQuestionOption $option): void
    {
        $entity = new DoctrineSurveyQuestionOption();
        $entity->setValue($option->value());
        $entity->setTitle($option->title());
        $entity->setOrder($option->order());

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function findById(string $id): ?SurveyQuestionOption
    {
        $entity = $this->entityManager->find(DoctrineSurveyQuestionOption::class, $id);

        if ($entity === null) {
            return null;
        }

        return new SurveyQuestionOption(
            (string) $entity->getId(),
            (string) $entity->getQuestion()->getId(),
            $entity->getValue(),
            $entity->getTitle(),
            (int) $entity->getOrder()
        );
    }

    /**
     * @return SurveyQuestionOption[]
     */
    public function findAll(): array
    {
        $entities = $this->entityManager->getRepository(DoctrineSurveyQuestionOption::class)->findAll();

        return array_map(function ($entity): SurveyQuestionOption {
            return new SurveyQuestionOption(
                (string) $entity->getId(),
                (string) $entity->getQuestion()->getId(),
                $entity->getValue(),
                $entity->getTitle(),
                (int) $entity->getOrder()
            );
        }, $entities);
    }
}
