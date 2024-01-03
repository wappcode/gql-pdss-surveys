<?php

namespace GPDSurvey\Entities;

use GPDSurvey\Entities\SurveyContent;
use Doctrine\ORM\Mapping as ORM;
use GraphQL\Doctrine\Annotation as API;
use GPDCore\Entities\AbstractEntityModelStringId;

/**
 * Doctrine Entity For SurveySectionItem
 * No se agregar indice único relacionado con el orden podria ocacionar conflictos en el procesos build
 * 
 * @ORM\Entity()
 * @ORM\Table(name="gpd_survey_section_item", indexes={
 * @ORM\Index(name="user_created_idx",columns={"created"}),
 * @ORM\Index(name="user_updated_idx",columns={"updated"})
 * }
 * )
 * 
 */
class SurveySectionItem  extends AbstractEntityModelStringId
{
    const RELATIONS_MANY_TO_ONE = ['conditions', 'section', 'question', 'content'];

    /**
     * @ORM\Column(type="string", name="item_type", nullable=false) 
     * @var string
     */
    private $type;
    /**
     * @ORM\Column(type="integer", name="order_number", nullable=false) 
     * @var int
     */
    private $order;
    /**
     * @ORM\ManyToOne(targetEntity="\GPDSurvey\Entities\SurveyConfiguration")
     * @ORM\JoinColumn(name="condition_id", referencedColumnName="id", nullable=true)
     * @var SurveyConfiguration
     */
    private $conditions;
    /**
     *
     * @ORM\OneToOne(targetEntity="\GPDSurvey\Entities\SurveyQuestion")
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id", nullable=true)
     * @var SurveyQuestion
     */
    private $question;
    /**
     *
     * @ORM\OneToOne(targetEntity="\GPDSurvey\Entities\SurveyContent")
     * @ORM\JoinColumn(name="content_id", referencedColumnName="id", nullable=true)
     * @var SurveyContent
     */
    private $content;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="\GPDSurvey\Entities\SurveySection", inversedBy="items")
     * @ORM\JoinColumn(name="section_id", referencedColumnName="id", nullable=false)
     *
     * @var SurveySection
     */
    private $section;
    /**
     * @ORM\Column(type="boolean", name="hidden", nullable=false, options={"default":0}) 
     * @var bool
     */
    private $hidden;


    public function __construct()
    {
        parent::__construct();
        $this->hidden = false;
    }

    /**
     * Get the value of type
     * @API\Field(type="GPDSurvey\Graphql\Types\TypeSurveySectionItemType")
     * @return  string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @API\Input(type="GPDSurvey\Graphql\Types\TypeSurveySectionItemType")
     * @param  string  $type
     *
     * @return  self
     */
    public function setType(string $type)
    {
        $this->type = $type;

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
     * Get the value of conditions
     *
     * @return  ?SurveyConfiguration
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * Set the value of conditions
     *
     * @param  ?SurveyConfiguration  $conditions
     *
     * @return  self
     */
    public function setConditions(?SurveyConfiguration $conditions)
    {
        $this->conditions = $conditions;

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
     * @param  ?SurveyQuestion  $question
     *
     * @return  self
     */
    public function setQuestion(?SurveyQuestion $question)
    {
        $this->question = $question;

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
     * Get the value of section
     *
     * @return  SurveySection
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * Set the value of section
     *
     * @param  SurveySection  $section
     *
     * @return  self
     */
    public function setSection(SurveySection $section)
    {
        $this->section = $section;

        return $this;
    }
    /**
     * Get hidden
     *
     * @return  bool
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * Set hidden
     *
     * @param  bool  $hidden  hidden
     *
     * @return  self
     */
    public function setHidden(bool $hidden)
    {
        $this->hidden = $hidden;

        return $this;
    }
}
