<?php

namespace GPDSurvey\Domain\Survey;

final class SurveyFactory
{
    public static function create(string $title, bool $active = true): Survey
    {
        return new Survey($title, $active);
    }
}
