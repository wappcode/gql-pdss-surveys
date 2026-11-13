<?php

namespace GPDSurvey\Application\Command\Survey;

use DateTime;

class CreateTargetAudienceCommand
{
    public function __construct(
        public string $survey,
        public string $title,
        public ?DateTime $starts,
        public ?DateTime $ends,
        public ?string $welcomeMessage,
        public ?string $farewellMessage,
        public ?int $attempts,
        public ?array $presentation,
        public ?string $password,
        public ?array $welcomeMessagePresentation,
        public ?array $farewellMessagePresentation,
    ) {}
}
