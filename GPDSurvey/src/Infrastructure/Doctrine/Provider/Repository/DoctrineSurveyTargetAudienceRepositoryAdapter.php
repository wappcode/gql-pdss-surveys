<?php

namespace GPDSurvey\Infrastructure\Doctrine\Provider\Repository;

use Doctrine\ORM\EntityManagerInterface;
use GPDSurvey\Domain\Entities\SurveyConfiguration;
use GPDSurvey\Domain\Entities\SurveyContent;
use GPDSurvey\Domain\Port\Repository\SurveyTargetAudienceRepositoryPort;
use GPDSurvey\Domain\Port\Repository\SurveyContentRepositoryPort;
use GPDSurvey\Domain\Port\Repository\SurveyConfigurationRepositoryPort;
use GPDSurvey\Domain\Entities\SurveyTargetAudience;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurvey;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveyConfiguration;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveyContent;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveyTargetAudience;
use GPDSurvey\Infrastructure\Doctrine\Mappers\DoctrineSurveyTargetAudienceToDomainMapper;
use GPDSurvey\Infrastructure\Doctrine\Mappers\DomainSurveyTargetAudienceToDoctrineMapper;

class DoctrineSurveyTargetAudienceRepositoryAdapter implements SurveyTargetAudienceRepositoryPort
{
    private EntityManagerInterface $entityManager;
    private SurveyContentRepositoryPort $contentRepository;
    private SurveyConfigurationRepositoryPort $configurationRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        SurveyContentRepositoryPort $contentRepository,
        SurveyConfigurationRepositoryPort $configurationRepository
    ) {
        $this->entityManager = $entityManager;
        $this->contentRepository = $contentRepository;
        $this->configurationRepository = $configurationRepository;
    }

    public function findById(string $id): ?SurveyTargetAudience
    {
        $doctrineSurveyTargetAudience = $this->entityManager->getRepository(DoctrineSurveyTargetAudience::class)->find($id);
        if (!$doctrineSurveyTargetAudience) {
            return null;
        }
        return DoctrineSurveyTargetAudienceToDomainMapper::fromDoctrine($doctrineSurveyTargetAudience);
    }
    public function create(SurveyTargetAudience $surveyTargetAudience): SurveyTargetAudience
    {
        $doctrineSurveyTargetAudience = DomainSurveyTargetAudienceToDoctrineMapper::fromDomain($surveyTargetAudience);
        $surveyId = $surveyTargetAudience->survey()->id()->value();
        $surveyReference = $this->entityManager->getReference(DoctrineSurvey::class, $surveyId);
        $presentation = $this->createPresentation($surveyTargetAudience->presentation());
        $farewell = $this->createContent($surveyTargetAudience->farewell());
        $welcome = $this->createContent($surveyTargetAudience->welcome());
        $doctrineSurveyTargetAudience->setSurvey($surveyReference);
        $doctrineSurveyTargetAudience->setPresentation($presentation);
        $doctrineSurveyTargetAudience->setFarewell($farewell);
        $doctrineSurveyTargetAudience->setWelcome($welcome);
        $this->entityManager->persist($doctrineSurveyTargetAudience);
        $this->entityManager->flush();
        $surveyTargetAudience = DoctrineSurveyTargetAudienceToDomainMapper::fromDoctrine($doctrineSurveyTargetAudience);
        return $surveyTargetAudience;
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
    private function createContent(SurveyContent $content): ?DoctrineSurveyContent
    {
        if (!$content) {
            return null;
        }
        $surveyContent = $this->contentRepository->create($content);
        $doctrineContent = $this->entityManager->getReference(DoctrineSurveyContent::class, $surveyContent->id()->value());
        return $doctrineContent;
    }
}
