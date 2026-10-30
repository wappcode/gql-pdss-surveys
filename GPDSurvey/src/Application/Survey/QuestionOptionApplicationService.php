<?php

namespace GPDSurvey\Application\Survey;

use GPDSurvey\Domain\Survey\SurveyQuestionOption;
use GPDSurvey\Infrastructure\Persistence\Doctrine\Repository\QuestionOptionDoctrineRepository;

final class QuestionOptionApplicationService
{
    public function __construct(private QuestionOptionDoctrineRepository $repository)
    {
    }

    /**
     * @return SurveyQuestionOption[]
     */
    public function list(): array
    {
        return $this->repository->findAll();
    }

    public function findById(string $id): ?SurveyQuestionOption
    {
        return $this->repository->findById($id);
    }

    public function create(string $id, string $questionId, string $value, string $title, int $order = 1): SurveyQuestionOption
    {
        $option = new SurveyQuestionOption($id, $questionId, $value, $title, $order);
        $this->repository->save($option);

        return $option;
    }
}
