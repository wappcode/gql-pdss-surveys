<?php

namespace GPDSurvey\Domain\Port\Repository;

use GPDSurvey\Domain\Entities\SurveyContent;

interface SurveyContentRepositoryPort
{
    public function create(SurveyContent $surveyContent): SurveyContent;
}
