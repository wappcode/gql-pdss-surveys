<?php

namespace GPDSurvey\Application\UseCase\Survey;

use GPDSurvey\Domain\Entities\SurveyTargetAudience;
use GPDSurvey\Application\Command\Survey\CreateTargetAudienceCommand;
use GPDSurvey\Domain\Entities\SurveyConfiguration;
use GPDSurvey\Domain\Entities\SurveyContent;
use GPDSurvey\Domain\Model\SurveyConfigurationType;
use GPDSurvey\Domain\Model\SurveyContentType;
use GPDSurvey\Domain\Port\Repository\SurveyRepositoryPort;
use GPDSurvey\Domain\Port\Repository\SurveyTargetAudienceRepositoryPort;
use GPDSurvey\Domain\ValueObject\IntID;
use GPDSurvey\Domain\ValueObject\SurveyConfigurationValue;
use GPDSurvey\Domain\ValueObject\SurveyContentBodyValue;
use GPDSurvey\Domain\ValueObject\ULID;

class CreateTargetAudienceUseCase
{
    private SurveyTargetAudienceRepositoryPort $targetAudienceRepository;
    private SurveyRepositoryPort $surveyRepository;

    public function __construct(SurveyTargetAudienceRepositoryPort $targetAudienceRepository, SurveyRepositoryPort $surveyRepository)
    {
        $this->targetAudienceRepository = $targetAudienceRepository;
        $this->surveyRepository = $surveyRepository;
    }

    public function execute(CreateTargetAudienceCommand $command): SurveyTargetAudience
    {
        $id = new ULID();
        $survey = $this->surveyRepository->findById($command->survey);
        if (!$survey) {
            throw new \Exception("Survey not found");
        }
        if ($command->welcomeMessage) {
            $welcomeBody = new SurveyContentBodyValue($command->welcomeMessage);
            $welcomePresentation = empty($command->welcomeMessagePresentation) ? [] : new SurveyConfiguration(
                new IntID(),
                new SurveyConfigurationValue($command->welcomeMessagePresentation),
                SurveyConfigurationType::PRESENTATION
            );
            $welcome = new SurveyContent(new IntID(), SurveyContentType::HTML, $welcomeBody);
        }
        if ($command->farewellMessage) {
            $farewellBody = new SurveyContentBodyValue($command->farewellMessage);
            $farewellPresentation = empty($command->farewellMessagePresentation) ? [] : new SurveyConfiguration(
                new IntID(),
                new SurveyConfigurationValue($command->farewellMessagePresentation),
                SurveyConfigurationType::PRESENTATION
            );
            $farewell = new SurveyContent(new IntID(), SurveyContentType::HTML, $farewellBody);
        }
        if ($command->presentation) {
            $presentation = new SurveyConfiguration(
                new IntID(),
                new SurveyConfigurationValue($command->presentation),
                SurveyConfigurationType::PRESENTATION
            );
        }

        $targetAudience = new SurveyTargetAudience(
            $id,
            $command->title,
            $survey,
            $command->starts,
            $command->ends,
            $welcome ?? null,
            $farewell ?? null,
            $command->attempts,
            $presentation ?? null,
            $command->password,
        );
        $this->targetAudienceRepository->create($targetAudience);
        return $targetAudience;
    }
}
