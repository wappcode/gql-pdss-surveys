<?php

namespace GPDSurvey\Domain\Survey;

enum SurveyStatus: string
{
    case DRAFT = 'draft';
    case ACTIVE = 'active';
    case ARCHIVED = 'archived';
}
