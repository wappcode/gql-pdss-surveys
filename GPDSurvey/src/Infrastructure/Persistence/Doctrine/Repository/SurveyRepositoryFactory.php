<?php

namespace GPDSurvey\Infrastructure\Persistence\Doctrine\Repository;

final class SurveyRepositoryFactory
{
    public static function create($entityManager): SurveyDoctrineRepository
    {
        return new SurveyDoctrineRepository($entityManager);
    }
}
