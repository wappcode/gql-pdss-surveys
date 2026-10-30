<?php

namespace GPDSurvey\Application\Survey;

use GPDSurvey\Domain\Survey\SurveyId;
use GPDSurvey\Domain\Survey\SurveyRepository;

final class GetSurveyByIdHandler
{
    public function __construct(private SurveyRepository $repository)
    {
    }

    public function handle(GetSurveyByIdQuery $query): ?SurveyViewModel
    {
        $survey = $this->repository->findById(new SurveyId($query->id));

        if ($survey === null) {
            return null;
        }

        return new SurveyViewModel(
            (string) $survey->getId(),
            $survey->getTitle(),
            $survey->isActive()
        );
    }
}
