<?php

namespace GPDSurvey\Domain\Model;

enum SurveyContentType: string
{
    case TEXT = 'TEXT';
    case HTML = 'HTML';
    case VIDEO = 'VIDEO';
    case IMAGE = 'IMAGE';
    case DIVIDER = 'DIVIDER';
    case AUDIO = 'AUDIO';
    case ANY = 'ANY';

    public function getValue(): string
    {
        return $this->value;
    }
}
