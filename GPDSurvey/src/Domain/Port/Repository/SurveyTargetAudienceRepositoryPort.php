<?php

namespace GPDSurvey\Domain\Port\Repository;

use GPDSurvey\Domain\Entities\SurveyTargetAudience;

interface SurveyTargetAudienceRepositoryPort
{
    public function create(SurveyTargetAudience $surveyTargetAudience): SurveyTargetAudience;

    public function findById(string $id): ?SurveyTargetAudience;
}
