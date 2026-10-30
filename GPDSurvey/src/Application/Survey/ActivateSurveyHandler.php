<?php

namespace GPDSurvey\Application\Survey;

use GPDSurvey\Domain\Survey\Survey;
use GPDSurvey\Domain\Survey\SurveyPolicy;
use GPDSurvey\Domain\Survey\SurveyRepository;

final class ActivateSurveyHandler
{
    public function __construct(private SurveyRepository $repository)
    {
    }

    public function handle(string $surveyId): Survey
    {
        $survey = $this->repository->findById(new \GPDSurvey\Domain\Survey\SurveyId($surveyId));

        if ($survey === null) {
            throw new \InvalidArgumentException('Survey not found');
        }

        if (!SurveyPolicy::canActivate($survey)) {
            throw new \RuntimeException('Survey cannot be activated');
        }

        $survey->setActive(true);
        $this->repository->save($survey);

        return $survey;
    }
}
