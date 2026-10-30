<?php

namespace GPDSurvey\Domain\Survey;

interface SurveyRepository
{
    public function save(Survey $survey): void;
    public function findById(SurveyId $id): ?Survey;
    /**
     * @return Survey[]
     */
    public function findAll(): array;
}
