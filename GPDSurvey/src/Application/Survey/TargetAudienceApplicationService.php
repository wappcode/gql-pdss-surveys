<?php

namespace GPDSurvey\Application\Survey;

use GPDSurvey\Domain\Survey\SurveyTargetAudience;

final class TargetAudienceApplicationService
{
    public function create(string $id, string $title): SurveyTargetAudience
    {
        return new SurveyTargetAudience($id, $title);
    }
}
