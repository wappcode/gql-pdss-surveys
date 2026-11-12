<?php

namespace GPDSurvey\Application\UseCase\Survey;

use GPDSurvey\Domain\Port\Repository\SurveyRepositoryPort;
use GPDSurvey\Application\Command\Survey\CreateSurveyCommand;
use GPDSurvey\Domain\Entities\Survey;
use GPDSurvey\Domain\ValueObject\ULID;

class CreateSurveyUseCase
{

    public function __construct(private SurveyRepositoryPort $surveyRepository) {}
    public function execute(CreateSurveyCommand $data): Survey
    {
        $id = new ULID();
        $survey = new Survey($id, $data->title, $data->active);
        $this->surveyRepository->create($survey);
        return $survey;
    }
}
