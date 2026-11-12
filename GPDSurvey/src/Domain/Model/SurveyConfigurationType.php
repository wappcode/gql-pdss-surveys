<?php

namespace GPDSurvey\Domain\Model;

enum SurveyConfigurationType: string
{
    case PRESENTATION = 'PRESENTATION';
    case VALIDATOR = 'VALIDATOR';
    case CONDITION = 'CONDITION';
    case ANSWER_SCORE = 'ANSWER_SCORE';
    public function getValue(): string
    {
        return $this->value;
    }
}
