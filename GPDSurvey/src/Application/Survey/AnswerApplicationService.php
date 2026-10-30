<?php

namespace GPDSurvey\Application\Survey;

use GPDSurvey\Domain\Survey\SurveyAnswer;
use GPDSurvey\Infrastructure\Persistence\Doctrine\Repository\AnswerDoctrineRepository;

final class AnswerApplicationService
{
    public function __construct(private AnswerDoctrineRepository $repository)
    {
    }

    /**
     * @return SurveyAnswer[]
     */
    public function list(): array
    {
        return $this->repository->findAll();
    }

    public function findById(string $id): ?SurveyAnswer
    {
        return $this->repository->findById($id);
    }

    public function create(string $id, string $questionId, string $sessionId, ?string $value = null, ?float $score = null, ?float $scorePercent = null): SurveyAnswer
    {
        $answer = new SurveyAnswer($id, $questionId, $sessionId, $value, $score, $scorePercent);
        $this->repository->save($answer);

        return $answer;
    }
}
