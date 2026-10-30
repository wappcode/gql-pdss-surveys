<?php

namespace GPDSurvey\Infrastructure\Persistence\Doctrine\Repository;

use GPDSurvey\Domain\Survey\Survey;
use GPDSurvey\Domain\Survey\SurveyId;
use GPDSurvey\Domain\Survey\SurveyRepository;
use GPDSurvey\Entities\Survey as DoctrineSurvey;
use GPDSurvey\Infrastructure\Persistence\Doctrine\Entity\SurveyEntityAdapter;

final class SurveyDoctrineRepository implements SurveyRepository
{
    public function __construct(private object $entityManager)
    {
    }

    public function save(Survey $survey): void
    {
        $entity = SurveyEntityAdapter::toDoctrine($survey);
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function findById(SurveyId $id): ?Survey
    {
        $entity = $this->entityManager->find(DoctrineSurvey::class, $id->value());

        if ($entity === null) {
            return null;
        }

        return SurveyEntityAdapter::toDomain($entity);
    }

    public function findAll(): array
    {
        $entities = $this->entityManager->getRepository(DoctrineSurvey::class)->findAll();

        return array_map(function ($entity): Survey {
            return SurveyEntityAdapter::toDomain($entity);
        }, $entities);
    }
}
