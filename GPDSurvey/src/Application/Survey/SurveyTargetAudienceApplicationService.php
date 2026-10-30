<?php

namespace GPDSurvey\Application\Survey;

use GPDSurvey\Domain\Survey\SurveyTargetAudience;
use GPDSurvey\Infrastructure\Persistence\Doctrine\Repository\TargetAudienceDoctrineRepository;

final class SurveyTargetAudienceApplicationService
{
    public function __construct(private TargetAudienceDoctrineRepository $repository)
    {
    }

    /**
     * @return SurveyTargetAudience[]
     */
    public function list(): array
    {
        return $this->repository->findAll();
    }

    public function create(string $id, string $title): SurveyTargetAudience
    {
        $targetAudience = new SurveyTargetAudience($id, $title);
        $this->repository->save($targetAudience);

        return $targetAudience;
    }
}
