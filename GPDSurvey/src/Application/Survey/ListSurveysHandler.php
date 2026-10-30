<?php

namespace GPDSurvey\Application\Survey;

use GPDSurvey\Domain\Survey\Survey;
use GPDSurvey\Domain\Survey\SurveyRepository;

final class ListSurveysHandler
{
    public function __construct(private SurveyRepository $repository)
    {
    }

    /**
     * @return Survey[]
     */
    public function handle(): array
    {
        return $this->repository->findAll();
    }
}
