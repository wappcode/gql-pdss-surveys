<?php

namespace GPDSurvey\Application\Survey;

final class SurveyViewModel
{
    public function __construct(
        public readonly string $id,
        public readonly string $title,
        public readonly bool $active
    ) {
    }
}
