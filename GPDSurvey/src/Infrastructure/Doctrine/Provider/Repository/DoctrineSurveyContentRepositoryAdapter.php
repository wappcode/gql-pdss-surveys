<?php

namespace GPDSurvey\Infrastructure\Doctrine\Provider\Repository;

use Doctrine\ORM\EntityManagerInterface;
use GPDSurvey\Domain\Entities\SurveyConfiguration;
use GPDSurvey\Domain\Port\Repository\SurveyContentRepositoryPort;
use GPDSurvey\Domain\Entities\SurveyContent;
use GPDSurvey\Domain\Port\Repository\SurveyConfigurationRepositoryPort;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveyConfiguration;
use GPDSurvey\Infrastructure\Doctrine\Mappers\DomainSurveyContentToDoctrineMapper;
use GPDSurvey\Infrastructure\Doctrine\Mappers\DoctrineSurveyContentToDomainMapper;

class DoctrineSurveyContentRepositoryAdapter implements SurveyContentRepositoryPort
{
    private EntityManagerInterface $entityManager;
    private SurveyConfigurationRepositoryPort $configurationRepository;

    public function __construct(EntityManagerInterface $entityManager, SurveyConfigurationRepositoryPort $configurationRepository)
    {
        $this->entityManager = $entityManager;
        $this->configurationRepository = $configurationRepository;
    }

    public function create(SurveyContent $surveyContent): SurveyContent
    {
        $doctrineSurveyContent = DomainSurveyContentToDoctrineMapper::fromDomain($surveyContent);
        $presentation = $this->createPresentation($surveyContent->presentation());

        $doctrineSurveyContent->setPresentation($presentation);
        $this->entityManager->persist($doctrineSurveyContent);
        $this->entityManager->flush();
        $updatedSurveyContent = DoctrineSurveyContentToDomainMapper::fromDoctrine($doctrineSurveyContent);
        return $updatedSurveyContent;
    }
    private function createPresentation(SurveyConfiguration $presentation): ?DoctrineSurveyConfiguration
    {
        if (!$presentation) {
            return null;
        }
        $presentation = $this->configurationRepository->create($presentation);
        $doctrinePresentation = $this->entityManager->getReference(DoctrineSurveyConfiguration::class, $presentation->id()->value());
        return $doctrinePresentation;
    }
}
