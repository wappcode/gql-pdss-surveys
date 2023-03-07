<?php

namespace GPDSurvey\Entities;

use GPDSurvey\Entities\SurveyContent;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use GPDCore\Entities\AbstractEntityModelStringId;
use Doctrine\Common\Collections\ArrayCollection;
use GraphQL\Doctrine\Annotation as API;

/**
 * Doctrine Entity For SurveySection
 * @ORM\Entity()
 * @ORM\Table(name="gpd_survey_section", indexes={
 * @ORM\Index(name="user_created_idx",columns={"created"}),
 * @ORM\Index(name="user_updated_idx",columns={"updated"})
 * }
 * )
 * 
 */
class SurveySection  extends AbstractEntityModelStringId
{
    const RELATIONS_MANY_TO_ONE = ['survey', 'content', 'presentation'];
    /**
     * @ORM\Column(type="string", name="title", nullable=false) 
     * @var string
     */
    private $title;
    /**
     * @ORM\ManyToOne(targetEntity="\GPDSurvey\Entities\SurveyContent")
     * @ORM\JoinColumn(name="content_id", referencedColumnName="id", nullable=true)
     * @var SurveyContent
     */
    private $content;
    /**
     * 
     * @ORM\OneToMany(targetEntity="\GPDSurvey\Entities\SurveySectionItem", mappedBy="section")
     * @var Collection
     */
    private $items;
    /**
     * @ORM\Column(type="integer", name="order_number", nullable=false) 
     * @var int
     */
    private $order;

    /**
     * Este valor no se registra dentro del valor presentation porque se utiliza para determinar que preguntas obligatorias no se han contestado
     * 
     * @ORM\Column(type="boolean", name="hidden", nullable=false, options={"default":0}) 
     * @var bool
     */
    private $hidden;

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
     * @ORM\ManyToOne(targetEntity="\GPDSurvey\Entities\Survey", inversedBy="sections")
     * @ORM\JoinColumn(name="survey_id", referencedColumnName="id", nullable=false)
     * @var Survey
     */
    private $survey;

    public function __construct()
    {
        parent::__construct();
        $this->items = new ArrayCollection();
        $this->hidden = false;
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
     * @param  SurveyContent  $content
     *
     * @return  self
     */
    public function setContent(?SurveyContent $content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the value of items
     *
     * @return  Collection
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    /**
     * Set the value of items
     *
     * @API\Exclude()
     * @param  Collection  $items
     *
     * @return  self
     */
    public function setItems(Collection $items)
    {
        $this->items = $items;

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
     *
     * @return  bool
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     *
     * @return  self
     */
    public function setHidden(bool $hidden = false)
    {
        $this->hidden = $hidden;

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
     * @param  SurveyConfiguration  $presentation
     *
     * @return  self
     */
    public function setPresentation(?SurveyConfiguration $presentation)
    {
        $this->presentation = $presentation;

        return $this;
    }

    /**
     * Get the value of survey
     *
     * @return  Survey
     */
    public function getSurvey()
    {
        return $this->survey;
    }

    /**
     * Set the value of survey
     *
     * @param  Survey  $survey
     *
     * @return  self
     */
    public function setSurvey(Survey $survey)
    {
        $this->survey = $survey;

        return $this;
    }
}
