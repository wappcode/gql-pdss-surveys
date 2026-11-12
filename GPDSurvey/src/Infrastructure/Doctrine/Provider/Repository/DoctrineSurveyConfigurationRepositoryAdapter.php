<?php

namespace GPDSurvey\Infrastructure\Doctrine\Provider\Repository;

use Doctrine\ORM\EntityManagerInterface;
use GPDSurvey\Domain\Port\Repository\SurveyConfigurationRepositoryPort;
use GPDSurvey\Domain\Entities\SurveyConfiguration;
use GPDSurvey\Infrastructure\Doctrine\Mappers\DomainSurveyConfigurationToDoctrineMapper;
use GPDSurvey\Infrastructure\Doctrine\Mappers\DoctrineSurveyConfigurationToDomainMapper;

class DoctrineSurveyConfigurationRepositoryAdapter implements SurveyConfigurationRepositoryPort
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(SurveyConfiguration $surveyConfig): SurveyConfiguration
    {
        $doctrineSurveyConfig = DomainSurveyConfigurationToDoctrineMapper::fromDomain($surveyConfig);
        $this->entityManager->persist($doctrineSurveyConfig);
        $this->entityManager->flush();
        $updatedSurveyConfig = DoctrineSurveyConfigurationToDomainMapper::fromDoctrine($doctrineSurveyConfig);
        return $updatedSurveyConfig;
    }
}
