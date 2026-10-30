<?php

namespace GPDSurvey\Application\Survey;

use GPDSurvey\Domain\Survey\SurveySection;
use GPDSurvey\Infrastructure\Persistence\Doctrine\Repository\SectionDoctrineRepository;

final class SurveySectionApplicationService
{
    public function __construct(private SectionDoctrineRepository $repository)
    {
    }

    /**
     * @return SurveySection[]
     */
    public function list(): array
    {
        return $this->repository->findAll();
    }

    public function findById(string $id): ?SurveySection
    {
        return $this->repository->findById($id);
    }

    public function create(string $id, string $title, int $order = 1, bool $hidden = false): SurveySection
    {
        $section = new SurveySection($id, $title, $order, $hidden);
        $this->repository->save($section);

        return $section;
    }
}
