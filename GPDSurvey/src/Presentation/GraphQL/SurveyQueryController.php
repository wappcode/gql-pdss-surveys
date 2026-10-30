<?php

namespace GPDSurvey\Presentation\GraphQL;

use GPDSurvey\Application\Survey\SurveyApplicationService;

final class SurveyQueryController
{
    public function __construct(private SurveyApplicationService $applicationService)
    {
    }

    public function create(string $title): array
    {
        $survey = $this->applicationService->create($title);

        return [
            'id' => $survey->id,
            'title' => $survey->title,
            'active' => $survey->active,
        ];
    }

    public function list(): array
    {
        return array_map(function ($survey): array {
            return [
                'id' => $survey->id,
                'title' => $survey->title,
                'active' => $survey->active,
            ];
        }, $this->applicationService->list());
    }

    public function getById(string $id): ?array
    {
        $survey = $this->applicationService->getById($id);

        if ($survey === null) {
            return null;
        }

        return [
            'id' => $survey->id,
            'title' => $survey->title,
            'active' => $survey->active,
        ];
    }
}
