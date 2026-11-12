<?php

namespace GPDSurvey\Application\UseCase\Survey;

use GPDSurvey\Domain\Port\Repository\SurveyRepositoryPort;
use GPDSurvey\Domain\Port\Repository\SurveyTargetAudienceRepositoryPort;
use GPDSurvey\Domain\Entities\Survey;
use GPDSurvey\Application\Command\Survey\CreateTargetAudienceWithSurveyCommand;
use GPDSurvey\Domain\Entities\SurveyConfiguration;
use GPDSurvey\Domain\Entities\SurveyContent;
use GPDSurvey\Domain\Entities\SurveyTargetAudience;
use GPDSurvey\Domain\Model\SurveyConfigurationType;
use GPDSurvey\Domain\Model\SurveyContentType;
use GPDSurvey\Domain\ValueObject\IntID;
use GPDSurvey\Domain\ValueObject\SurveyConfigurationValue;
use GPDSurvey\Domain\ValueObject\SurveyContentBodyValue;
use GPDSurvey\Domain\ValueObject\ULID;

class CreateTargetAudienceWithSurveyUseCase
{
    private SurveyRepositoryPort $surveyRepository;
    private SurveyTargetAudienceRepositoryPort $surveyTargetAudienceRepository;
    public function __construct(
        SurveyRepositoryPort $surveyRepository,
        SurveyTargetAudienceRepositoryPort $surveyTargetAudienceRepository,
    ) {
        $this->surveyRepository = $surveyRepository;
        $this->surveyTargetAudienceRepository = $surveyTargetAudienceRepository;
    }

    public function execute(CreateTargetAudienceWithSurveyCommand $command): SurveyTargetAudience
    {

        $survye = $this->createSurvey($command);
        $targetAudience = $this->createSurveyTargetAudience($survye, $command);
        $this->surveyTargetAudienceRepository->create($targetAudience);
        return $targetAudience;
    }

    private function createSurvey(CreateTargetAudienceWithSurveyCommand $command): Survey
    {
        $surveyId = new ULID();
        $survey = new Survey($surveyId, $command->title, $command->active);
        $this->surveyRepository->create($survey);
        return $survey;
    }
    private function createSurveyTargetAudience(Survey $survey, CreateTargetAudienceWithSurveyCommand $command)
    {
        $targetAudienceId = new ULID();
        $presentation = $this->createPresentation($command->presentation);
        $welcome = $this->createContent($command->welcomeMessage, SurveyContentType::HTML, $command->welcomeMessagePresentation);
        $farewell = $this->createContent($command->farwellMessage, SurveyContentType::HTML, $command->farewellMessagePresentation);

        $surveyTargetAudience = new SurveyTargetAudience(
            $targetAudienceId,
            $command->title,
            $survey,
            $command->starts,
            $command->ends,
            $welcome,
            $farewell,
            $command->attempts,
            $presentation,
            $command->password
        );
        $this->surveyTargetAudienceRepository->create($surveyTargetAudience);
        return $surveyTargetAudience;
    }

    private function createPresentation(array $presentation): ?SurveyConfiguration
    {
        if (!$presentation) {
            return null;
        }

        $surveyConfigurationId = new IntID();
        $value = new SurveyConfigurationValue($presentation);
        $surveyConfiguration = new SurveyConfiguration(
            $surveyConfigurationId,
            $value,
            SurveyConfigurationType::PRESENTATION
        );
        return $surveyConfiguration;
    }
    private function createContent(string $body, ?SurveyContentType $type, ?array $presentation): ?SurveyContent
    {
        if (!$body) {
            return null;
        }

        $id = new IntID();
        $value = new SurveyContentBodyValue($body);
        $type = $type ?? SurveyContentType::HTML;
        if ($presentation) {
            $presentation = $this->createPresentation($presentation);
        }

        $surveyContent = new SurveyContent(
            $id,
            $type,
            $value,
            $presentation ?? null,
        );
        return $surveyContent;
    }
}
