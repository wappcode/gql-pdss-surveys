<?php

namespace GPDSurvey\Application\Survey;

final class CreateSurveyCommand
{
    public function __construct(public readonly string $title)
    {
    }
}
