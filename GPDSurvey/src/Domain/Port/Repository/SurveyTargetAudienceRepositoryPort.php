<?php

namespace GPDSurvey\Domain\Port\Repository;

use GPDSurvey\Domain\Entities\SurveyTargetAudience;

interface SurveyTargetAudienceRepositoryPort
{
    public function create(SurveyTargetAudience $surveyTargetAudience): SurveyTargetAudience;
}
