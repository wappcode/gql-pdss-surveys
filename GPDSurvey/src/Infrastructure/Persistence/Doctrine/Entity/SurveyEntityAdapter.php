<?php

namespace GPDSurvey\Infrastructure\Persistence\Doctrine\Entity;

use GPDSurvey\Domain\Survey\Survey;
use GPDSurvey\Domain\Survey\SurveyId;
use GPDSurvey\Entities\Survey as DoctrineSurvey;

final class SurveyEntityAdapter
{
    public static function toDomain(DoctrineSurvey $entity): Survey
    {
        return new Survey(
            $entity->getTitle(),
            $entity->getActive(),
            new SurveyId((string) $entity->getId())
        );
    }

    public static function toDoctrine(Survey $survey): DoctrineSurvey
    {
        $entity = new DoctrineSurvey();
        $entity->setTitle($survey->getTitle());
        $entity->setActive($survey->isActive());

        if ((string) $survey->getId() !== '') {
            $entity->id = (string) $survey->getId();
        }

        return $entity;
    }
}
