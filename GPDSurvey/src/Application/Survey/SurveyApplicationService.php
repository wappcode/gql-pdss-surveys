<?php

namespace GPDSurvey\Application\Survey;

use GPDSurvey\Domain\Survey\SurveyRepository;

final class SurveyApplicationService
{
    public function __construct(
        private CreateSurveyHandler $createSurveyHandler,
        private SurveyQueryService $queryService,
        private GetSurveyByIdHandler $getSurveyByIdHandler,
        private UpdateSurveyTitleHandler $updateSurveyTitleHandler,
        private ActivateSurveyHandler $activateSurveyHandler
    ) {
    }

    public function create(string $title): SurveyViewModel
    {
        $survey = $this->createSurveyHandler->handle(new CreateSurveyCommand($title));

        return new SurveyViewModel(
            (string) $survey->getId(),
            $survey->getTitle(),
            $survey->isActive()
        );
    }

    /**
     * @return SurveyViewModel[]
     */
    public function list(): array
    {
        return $this->queryService->list();
    }

    public function getById(string $id): ?SurveyViewModel
    {
        return $this->getSurveyByIdHandler->handle(new GetSurveyByIdQuery($id));
    }

    public function updateTitle(string $surveyId, string $title): SurveyViewModel
    {
        $survey = $this->updateSurveyTitleHandler->handle($surveyId, $title);

        return new SurveyViewModel(
            (string) $survey->getId(),
            $survey->getTitle(),
            $survey->isActive()
        );
    }

    public function activate(string $surveyId): SurveyViewModel
    {
        $survey = $this->activateSurveyHandler->handle($surveyId);

        return new SurveyViewModel(
            (string) $survey->getId(),
            $survey->getTitle(),
            $survey->isActive()
        );
    }
}
