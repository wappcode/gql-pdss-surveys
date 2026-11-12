<?php

namespace GPDSurvey\Infrastructure\Doctrine\Provider\Repository;

use Doctrine\ORM\EntityManagerInterface;
use GPDSurvey\Domain\Port\Repository\SurveyRepositoryPort;
use GPDSurvey\Domain\Entities\Survey;
use GPDSurvey\Infrastructure\Doctrine\Mappers\DoctrineSurveyToDomainMapper;
use GPDSurvey\Infrastructure\Doctrine\Mappers\DomainSurveyToDoctrineMapper;

class DoctrineSurveyRepositoryAdapter implements SurveyRepositoryPort
{


    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function create(Survey $survey): Survey
    {
        $doctrineSurvey = DomainSurveyToDoctrineMapper::fromDomain($survey);
        $this->entityManager->persist($doctrineSurvey);
        $this->entityManager->flush();
        $survey = DoctrineSurveyToDomainMapper::fromDoctrine($doctrineSurvey);
        return $survey;
    }
}
