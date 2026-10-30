<?php

namespace GPDSurvey\Application\Survey;

final class GetSurveyByIdQuery
{
    public function __construct(public readonly string $id)
    {
    }
}
