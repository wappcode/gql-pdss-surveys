<?php

namespace GPDSurvey\Application\Command\Survey;

class CreateSurveyCommand
{

    public string $title;
    public bool $active;
    public function __construct(string $title, bool $active)
    {
        $this->title = $title;
        $this->active = $active;
    }
}
