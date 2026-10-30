<?php

namespace GPDSurvey\Infrastructure\Persistence\Doctrine\Repository;

use GPDSurvey\Domain\Survey\SurveyConfiguration;
use GPDSurvey\Entities\SurveyConfiguration as DoctrineSurveyConfiguration;

final class ConfigurationDoctrineRepository
{
    public function __construct(private object $entityManager)
    {
    }

    public function save(SurveyConfiguration $configuration): void
    {
        $entity = new DoctrineSurveyConfiguration();
        $entity->setValue($configuration->value());
        $entity->setType($configuration->type());

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function findById(string $id): ?SurveyConfiguration
    {
        $entity = $this->entityManager->find(DoctrineSurveyConfiguration::class, $id);

        if ($entity === null) {
            return null;
        }

        return new SurveyConfiguration(
            (string) $entity->getId(),
            $entity->getValue(),
            $entity->getType()
        );
    }

    /**
     * @return SurveyConfiguration[]
     */
    public function findAll(): array
    {
        $entities = $this->entityManager->getRepository(DoctrineSurveyConfiguration::class)->findAll();

        return array_map(function ($entity): SurveyConfiguration {
            return new SurveyConfiguration(
                (string) $entity->getId(),
                $entity->getValue(),
                $entity->getType()
            );
        }, $entities);
    }
}
