<?php

namespace GPDSurvey\Domain\Port\Repository;

use GPDSurvey\Domain\Entities\Survey;

interface SurveyRepositoryPort
{
    public function create(Survey $survey): Survey;
    public function findById(string $id): ?Survey;
}
