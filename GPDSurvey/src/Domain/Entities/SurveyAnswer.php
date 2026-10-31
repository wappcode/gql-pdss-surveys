<?php

namespace GPDSurvey\Domain\Entities;

use GPDSurvey\Domain\ValueObject\AnswerValue;
use GPDSurvey\Domain\ValueObject\IntID;

class SurveyAnswer
{

    protected \DateTimeImmutable $created;
    protected \DateTimeImmutable $updated;


    public function __construct(
        private IntID $id,
        private AnswerValue $value,
        private ?float $score = null,
        private ?float $scorePercent = null,
        private ?SurveyQuestion $question = null,
        private ?SurveyAnswerSession $session = null
    ) {
        $this->created = new \DateTimeImmutable();
        $this->updated = new \DateTimeImmutable();
    }

    public function id(): IntID
    {
        return $this->id;
    }

    public function value(): ?AnswerValue
    {
        return $this->value;
    }

    public function changeValue(?AnswerValue $value): self
    {
        $this->value = $value;
        $this->touch();
        return $this;
    }

    /**
     *
     * @return  ?SurveyQuestion
     */
    public function question(): ?SurveyQuestion
    {
        return $this->question;
    }

    /**
     *
     * @return  ?float
     */
    public function score(): ?float
    {
        return $this->score;
    }


    /**
     *
     * @return  ?float
     */
    public function scorePercent(): ?float
    {
        return $this->scorePercent;
    }
    public function created(): \DateTimeImmutable
    {
        return $this->created;
    }

    public function updated(): \DateTimeImmutable
    {
        return $this->updated;
    }

    /**
     *
     * @return  SurveyAnswerSession
     */
    public function session(): ?SurveyAnswerSession
    {
        return $this->session;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id()->value(),
            'value' => $this->value()?->value(),
            'score' => $this->score(),
            'scorePercent' => $this->scorePercent(),
            'question' => $this->question() !== null ? $this->question()->toArray() : null,
            'session' => $this->session() !== null ? $this->session()->toArray() : null,
            'created' => $this->created()->format(\DateTimeInterface::ATOM),
            'updated' => $this->updated()->format(\DateTimeInterface::ATOM),
        ];
    }

    private function touch(): self
    {
        $this->updated = new \DateTimeImmutable();

        return $this;
    }
}
