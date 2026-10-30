<?php

namespace GPDSurvey\Application\Survey;

use GPDSurvey\Domain\Survey\Survey;
use GPDSurvey\Domain\Survey\SurveyPolicy;
use GPDSurvey\Domain\Survey\SurveyRepository;

final class UpdateSurveyTitleHandler
{
    public function __construct(private SurveyRepository $repository)
    {
    }

    public function handle(string $surveyId, string $title): Survey
    {
        $survey = $this->repository->findById(new \GPDSurvey\Domain\Survey\SurveyId($surveyId));

        if ($survey === null) {
            throw new \InvalidArgumentException('Survey not found');
        }

        if (!SurveyPolicy::canUpdate($survey)) {
            throw new \RuntimeException('Survey cannot be updated');
        }

        $survey->setTitle($title);
        $this->repository->save($survey);

        return $survey;
    }
}
