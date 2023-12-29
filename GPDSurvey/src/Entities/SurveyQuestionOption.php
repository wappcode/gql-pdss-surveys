<?php

namespace GPDSurvey\Entities;

use GPDCore\Entities\AbstractEntityModel;
use GPDSurvey\Entities\SurveyContent;
use GPDSurvey\Entities\SurveyQuestion;
use Doctrine\ORM\Mapping as ORM;
use GraphQL\Doctrine\Annotation as API;

/**
 * Doctrine Entity For SurveyQuestionOption
 * @ORM\Entity()
 * @ORM\Table(name="gpd_survey_question_option", indexes={
 * @ORM\Index(name="user_created_idx",columns={"created"}),
 * @ORM\Index(name="user_updated_idx",columns={"updated"})
 * })
 * 
 */
class SurveyQuestionOption  extends AbstractEntityModel
{
    const RELATIONS_MANY_TO_ONE = ['content', 'presentation', 'question'];
    /**
     * @ORM\Column(type="string", length="5000", name="option_value", nullable=false) 
     * @var mixed
     */
    private $value;
    /**
     * @ORM\Column(type="string", length="5000",  name="title", nullable=false) 
     * @var string
     */
    private $title;
    /**
     * @ORM\Column(type="integer", name="order_number", nullable=false) 
     * @var int
     */
    private $order;
    /**
     * @var SurveyContent
     * @ORM\ManyToOne(targetEntity="\GPDSurvey\Entities\SurveyContent")
     * @ORM\JoinColumn(name="content_id", referencedColumnName="id", nullable=true)
     * 
     */
    private $content;
    /**
     *
     * @ORM\OneToOne(targetEntity="\GPDSurvey\Entities\SurveyConfiguration")
     * @ORM\JoinColumn(name="presentation_id", referencedColumnName="id", nullable=true)
     * @var SurveyConfiguration
     * 
     */
    private $presentation;

    /**
     *
     * @ORM\ManyToOne(targetEntity="SurveyQuestion", inversedBy="options")
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id", nullable=false)
     * @var SurveyQuestion
     */
    private $question;

    /**
     * Get the value of value
     * 
     * @return  string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of value
     * 
     * @param  mixed  $value
     *
     * @return  self
     */
    public function setValue(string $value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the value of title
     *
     * @return  string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @param  string  $title
     *
     * @return  self
     */
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of order
     *
     * @return  int
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set the value of order
     *
     * @param  int  $order
     *
     * @return  self
     */
    public function setOrder(int $order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get the value of content
     *
     * @return  ?SurveyContent
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @param  ?SurveyContent  $content
     *
     * @return  self
     */
    public function setContent(?SurveyContent $content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the value of presentation
     *
     * @return  ?SurveyConfiguration
     */
    public function getPresentation()
    {
        return $this->presentation;
    }

    /**
     * Set the value of presentation
     *
     * @param  ?SurveyConfiguration  $presentation
     *
     * @return  self
     */
    public function setPresentation(?SurveyConfiguration $presentation)
    {
        $this->presentation = $presentation;

        return $this;
    }

    /**
     * Get the value of question
     *
     * @return  SurveyQuestion
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
    public function setQuestion(SurveyQuestion $question)
    {
        $this->question = $question;

        return $this;
    }
}
