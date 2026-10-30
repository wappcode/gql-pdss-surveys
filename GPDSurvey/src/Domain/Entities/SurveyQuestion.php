<?php

namespace GPDSurvey\Domain\Entities;

use GPDSurvey\Domain\Entities\Survey;
use GPDSurvey\Domain\Entities\SurveyContent;
use GPDSurvey\Domain\Entities\SurveyConfiguration;
use GPDSurvey\Domain\ValueObject\ULid;

class SurveyQuestion
{
    protected \DateTimeImmutable $created;
    protected \DateTimeImmutable $updated;



    public function __construct(
        private ULid $id,
        private string $title,
        private string $code,
        private string $type,
        private Survey $survey,
        private bool $required = false,
        private bool $other = false,
        private ?float $score = 1,
        private ?array $options = null,
        private ?SurveyContent $hint = null,
        private ?SurveyContent $content = null,
        private ?SurveyConfiguration $presentation = null,
        private ?SurveyConfiguration $validators = null,
        private ?SurveyConfiguration $answerScore = null,
    ) {
        $this->created = new \DateTimeImmutable();
        $this->updated = new \DateTimeImmutable();
    }
    public function id(): ULid
    {
        return $this->id;
    }
    public function title()
    {
        return $this->title;
    }
    public function code()
    {
        return $this->code;
    }
    /**
     * Set the value of type
     * CHECKBOX_LIST
     * DATE
     * DATE_RANGE
     * DATETIME
     * EMAIL
     * FILE
     * IMAGE
     * NUMBER
     * NUMBER_LIST
     * ONE_LINE_TEXT
     * PHONE
     * RADIO_LIST
     * SHORT_TEXT
     * @return  string
     */
    public function type()
    {
        return $this->type;
    }

    public function required()
    {
        return $this->required;
    }

    public function other()
    {
        return $this->other;
    }
    /**
     * @return SurveyQuestionOption[]|null
     */
    public function options()
    {
        return $this->options;
    }

    public function content(): ?SurveyContent
    {
        return $this->content;
    }
    public function presentation(): ?SurveyConfiguration
    {
        return $this->presentation;
    }

    public function validators(): ?SurveyConfiguration
    {
        return $this->validators;
    }

    public function answerScore(): ?SurveyConfiguration
    {
        return $this->answerScore;
    }

    public function score(): ?float
    {
        return $this->score;
    }

    public function survey(): Survey
    {
        return $this->survey;
    }


    public function hint(): ?SurveyContent
    {
        return $this->hint;
    }

    private function touch(): self
    {
        $this->updated = new \DateTimeImmutable();

        return $this;
    }
}
