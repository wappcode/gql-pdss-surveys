<?php

namespace GPDSurvey\Domain\Survey;

final class SurveyQuestionOption
{
    public function __construct(
        private string $id,
        private string $questionId,
        private string $value,
        private string $title,
        private int $order = 1
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function questionId(): string
    {
        return $this->questionId;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function order(): int
    {
        return $this->order;
    }
}
