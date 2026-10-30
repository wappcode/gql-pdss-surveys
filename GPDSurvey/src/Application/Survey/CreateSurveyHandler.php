<?php

namespace GPDSurvey\Application\Survey;

use GPDSurvey\Domain\Survey\Survey;
use GPDSurvey\Domain\Survey\SurveyFactory;
use GPDSurvey\Domain\Survey\SurveyRepository;

final class CreateSurveyHandler
{
    public function __construct(private SurveyRepository $repository)
    {
    }

    public function handle(CreateSurveyCommand $command): Survey
    {
        $survey = SurveyFactory::create($command->title);
        $this->repository->save($survey);

        return $survey;
    }
}
