<?php

namespace GPDSurvey\Infrastructure\Doctrine\Entities;

use Doctrine\ORM\Mapping as ORM;
use PDSSUtilities\AbstractEntityModel;

#[ORM\Entity]
#[ORM\Table(
    name: 'gpd_survey_question_option',
    indexes: [
        new ORM\Index(name: 'user_created_idx', columns: ['created']),
        new ORM\Index(name: 'user_updated_idx', columns: ['updated']),
    ]
)]
class DoctrineSurveyQuestionOption extends AbstractEntityModel
{


    #[ORM\Column(type: 'string', length: 5000, name: 'option_value', nullable: false)]
    private string $value;

    #[ORM\Column(type: 'string', length: 5000, name: 'title', nullable: false)]
    private string $title;

    #[ORM\Column(type: 'integer', name: 'order_number', nullable: false)]
    private int $order;

    #[ORM\ManyToOne(targetEntity: DoctrineSurveyContent::class)]
    #[ORM\JoinColumn(name: 'content_id', referencedColumnName: 'id', nullable: true)]
    private ?DoctrineSurveyContent $content;

    #[ORM\ManyToOne(targetEntity: DoctrineSurveyConfiguration::class)]
    #[ORM\JoinColumn(name: 'presentation_id', referencedColumnName: 'id', nullable: true)]
    private ?DoctrineSurveyConfiguration $presentation;

    #[ORM\ManyToOne(targetEntity: DoctrineSurveyQuestion::class, inversedBy: 'options')]
    #[ORM\JoinColumn(name: 'question_id', referencedColumnName: 'id', nullable: false)]
    private DoctrineSurveyQuestion $question;

    #[ORM\Column(type: 'datetimetz_immutable', name: 'created', nullable: false)]
    protected \DateTimeImmutable $created;

    #[ORM\Column(type: 'datetimetz_immutable', name: 'updated', nullable: false)]
    protected \DateTimeImmutable $updated;
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
     * @param  string  $value
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
     * @return  ?DoctrineSurveyContent
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @param  ?DoctrineSurveyContent  $content
     *
     * @return  self
     */
    public function setContent(?DoctrineSurveyContent $content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the value of presentation
     *
     * @return  ?DoctrineSurveyConfiguration
     */
    public function getPresentation()
    {
        return $this->presentation;
    }

    /**
     * Set the value of presentation
     *
     * @param  ?DoctrineSurveyConfiguration  $presentation
     *
     * @return  self
     */
    public function setPresentation(?DoctrineSurveyConfiguration $presentation)
    {
        $this->presentation = $presentation;

        return $this;
    }

    /**
     * Get the value of question
     *
     * @return  DoctrineSurveyQuestion
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set the value of question
     *
     * @param  DoctrineSurveyQuestion  $question
     *
     * @return  self
     */
    public function setQuestion(DoctrineSurveyQuestion $question)
    {
        $this->question = $question;

        return $this;
    }
}
