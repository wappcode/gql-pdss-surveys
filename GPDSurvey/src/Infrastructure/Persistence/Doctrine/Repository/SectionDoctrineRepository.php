<?php

namespace GPDSurvey\Infrastructure\Persistence\Doctrine\Repository;

use GPDSurvey\Domain\Survey\SurveySection;
use GPDSurvey\Entities\SurveySection as DoctrineSurveySection;

final class SectionDoctrineRepository
{
    public function __construct(private object $entityManager)
    {
    }

    public function save(SurveySection $section): void
    {
        $entity = new DoctrineSurveySection();
        $entity->setTitle($section->title());
        $entity->setOrder($section->order());
        $entity->setHidden($section->isHidden());

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function findById(string $id): ?SurveySection
    {
        $entity = $this->entityManager->find(DoctrineSurveySection::class, $id);

        if ($entity === null) {
            return null;
        }

        return new SurveySection(
            (string) $entity->getId(),
            $entity->getTitle(),
            (int) $entity->getOrder(),
            (bool) $entity->getHidden()
        );
    }

    /**
     * @return SurveySection[]
     */
    public function findAll(): array
    {
        $entities = $this->entityManager->getRepository(DoctrineSurveySection::class)->findAll();

        return array_map(function ($entity): SurveySection {
            return new SurveySection(
                (string) $entity->getId(),
                $entity->getTitle(),
                (int) $entity->getOrder(),
                (bool) $entity->getHidden()
            );
        }, $entities);
    }
}
