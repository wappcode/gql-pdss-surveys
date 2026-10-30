<?php

namespace GPDSurvey\Application\Survey;

use GPDSurvey\Domain\Survey\SurveyRepository;

final class SurveyQueryService
{
    public function __construct(private SurveyRepository $repository)
    {
    }

    public function list(): array
    {
        return array_map(function ($survey): SurveyViewModel {
            return new SurveyViewModel(
                (string) $survey->getId(),
                $survey->getTitle(),
                $survey->isActive()
            );
        }, $this->repository->findAll());
    }

    public function getById(string $id): ?SurveyViewModel
    {
        $survey = $this->repository->findById(new \GPDSurvey\Domain\Survey\SurveyId($id));

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
