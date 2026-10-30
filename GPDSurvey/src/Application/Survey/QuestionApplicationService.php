<?php

namespace GPDSurvey\Application\Survey;

use GPDSurvey\Domain\Survey\SurveyQuestion;
use GPDSurvey\Infrastructure\Persistence\Doctrine\Repository\QuestionDoctrineRepository;

final class QuestionApplicationService
{
    public function __construct(private QuestionDoctrineRepository $repository)
    {
    }

    /**
     * @return SurveyQuestion[]
     */
    public function list(): array
    {
        return $this->repository->findAll();
    }

    public function findById(string $id): ?SurveyQuestion
    {
        return $this->repository->findById($id);
    }

    public function create(string $id, string $title, string $code, bool $required = false, bool $other = false, ?float $score = null): SurveyQuestion
    {
        $question = new SurveyQuestion($id, $title, $code, $required, $other, $score);
        $this->repository->save($question);

        return $question;
    }
}
