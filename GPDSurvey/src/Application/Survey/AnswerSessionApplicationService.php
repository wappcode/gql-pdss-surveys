<?php

namespace GPDSurvey\Application\Survey;

use GPDSurvey\Domain\Survey\SurveyAnswerSession;
use GPDSurvey\Infrastructure\Persistence\Doctrine\Repository\AnswerSessionDoctrineRepository;

final class AnswerSessionApplicationService
{
    public function __construct(private AnswerSessionDoctrineRepository $repository)
    {
    }

    /**
     * @return SurveyAnswerSession[]
     */
    public function list(): array
    {
        return $this->repository->findAll();
    }

    public function findById(string $id): ?SurveyAnswerSession
    {
        return $this->repository->findById($id);
    }

    public function create(
        string $id,
        string $targetAudienceId,
        string $surveyId,
        ?string $name = null,
        ?string $username = null,
        ?string $password = null,
        ?string $ownerCode = null,
        ?float $score = null,
        bool $completed = false,
        ?float $scorePercent = null
    ): SurveyAnswerSession {
        $session = new SurveyAnswerSession(
            $id,
            $targetAudienceId,
            $surveyId,
            $name,
            $username,
            $password,
            $ownerCode,
            $score,
            $completed,
            $scorePercent
        );
        $this->repository->save($session);

        return $session;
    }
}
