<?php

namespace GPDSurvey\Domain\Survey;

final class SurveyPolicy
{
    public static function canUpdate(Survey $survey): bool
    {
        return true;
    }

    public static function canActivate(Survey $survey): bool
    {
        return true;
    }
}
