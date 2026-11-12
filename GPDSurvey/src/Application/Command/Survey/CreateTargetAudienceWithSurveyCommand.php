<?php

namespace GPDSurvey\Application\Command\Survey;

use DateTime;

class CreateTargetAudienceWithSurveyCommand
{




    public function __construct(
        public string $title,
        public string $description,
        public bool $active,
        public ?DateTime $starts,
        public ?DateTime $ends,
        public ?string $welcomeMessage,
        public ?string $farwellMessage,
        public ?int $attempts,
        public ?array $presentation,
        public ?string $password,
        public ?array $welcomeMessagePresentation,
        public ?array $farewellMessagePresentation,
    ) {}
}
