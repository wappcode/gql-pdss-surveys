<?php

declare(strict_types=1);

namespace Tests\Support;

use Doctrine\ORM\EntityManagerInterface;
use GPDSurvey\Domain\ValueObject\ULID;
use GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurvey;

final class SurveyFactory
{
    public static function create(EntityManagerInterface $entityManager, string $title = 'Test survey', bool $active = true): DoctrineSurvey
    {
        $survey = new DoctrineSurvey();
        $reflection = new \ReflectionProperty(DoctrineSurvey::class, 'id');
        $reflection->setAccessible(true);
        $reflection->setValue($survey, (new ULID())->value());
        $survey->setTitle($title);
        $survey->setActive($active);

        $entityManager->persist($survey);
        $entityManager->flush();

        return $survey;
    }
}
