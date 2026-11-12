<?php

namespace GPDSurvey\Domain\Port\Repository;

use GPDSurvey\Domain\Entities\SurveyConfiguration;

interface SurveyConfigurationRepositoryPort
{
    public function create(SurveyConfiguration $surveyConfig): SurveyConfiguration;
}
