<?php

namespace GPDSurvey\Application\Survey;

use GPDSurvey\Domain\Survey\SurveyConfiguration;
use GPDSurvey\Infrastructure\Persistence\Doctrine\Repository\ConfigurationDoctrineRepository;

final class ConfigurationApplicationService
{
    public function __construct(private ConfigurationDoctrineRepository $repository)
    {
    }

    /**
     * @return SurveyConfiguration[]
     */
    public function list(): array
    {
        return $this->repository->findAll();
    }

    public function findById(string $id): ?SurveyConfiguration
    {
        return $this->repository->findById($id);
    }

    public function create(string $id, string $value, string $type): SurveyConfiguration
    {
        $configuration = new SurveyConfiguration($id, $value, $type);
        $this->repository->save($configuration);

        return $configuration;
    }
}
