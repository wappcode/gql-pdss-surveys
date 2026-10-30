<?php

namespace GPDSurvey\Entities;

use GraphQL\Doctrine\Annotation as API;

class SurveyAnswer
{
    protected $id;
    protected $created;
    protected $updated;

    const RELATIONS_MANY_TO_ONE = ['question', 'session'];
    /**
     * @ORM\Column(type="text", name="answer_value", nullable=true) 
     * @var ?string
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="\GPDSurvey\Entities\SurveyQuestion")
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id", nullable=false)
     * @var SurveyQuestion
     */
    private $question;
    /**
     *
     * @ORM\Column(type="decimal",name="score",  precision=10, scale=4, nullable=true)
     * @var float
     */
    private $score;
    /**
     *
     * @ORM\Column(type="decimal", name="score_percent", precision=8, scale=4, nullable=true)
     * @var float
     */
    private $scorePercent;

    /**
     * @ORM\ManyToOne(targetEntity="\GPDSurvey\Entities\SurveyAnswerSession", inversedBy="answers")
     * @ORM\JoinColumn(name="session_id", referencedColumnName="id", nullable=false)
     *
     * @var SurveyAnswerSession
     */
    private $session;

    /**
     * Get the value of value
     * @return  ?string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of value
     * @param  string  $value
     *
     * @return  self
     */
    public function setValue(?string $value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the value of question
     *
     * @return  ?SurveyQuestion
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set the value of question
     *
     * @param  SurveyQuestion  $question
     *
     * @return  self
     */
    public function setQuestion(?SurveyQuestion $question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get the value of score
     *
     * @return  ?float
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set the value of score
     *
     * @param  ?float  $score
     *
     * @return  self
     */
    public function setScore(?float $score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get the value of scorePercent
     *
     * @return  ?float
     */
    public function getScorePercent()
    {
        return $this->scorePercent;
    }

    /**
     * Set the value of scorePercent
     *
     * @param  ?float  $scorePercent
     *
     * @return  self
     */
    public function setScorePercent(?float $scorePercent)
    {
        $this->scorePercent = $scorePercent;

        return $this;
    }

    /**
     * Get the value of session
     *
     * @return  SurveyAnswerSession
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Set the value of session
     *
     * @param  SurveyAnswerSession  $session
     *
     * @return  self
     */
    public function setSession(SurveyAnswerSession $session)
    {
        $this->session = $session;

        return $this;
    }
}
