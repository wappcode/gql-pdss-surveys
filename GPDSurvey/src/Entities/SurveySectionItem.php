<?php

namespace GPDSurvey\Entities;

use GPDSurvey\Entities\SurveyContent;
use Doctrine\ORM\Mapping as ORM;

use PDSSUtilities\AbstractEntityModelUlid;

/**
 * Doctrine Entity For SurveySectionItem
 * No se agregar indice único relacionado con el orden podria ocacionar conflictos en el procesos build
 */
#[ORM\Entity]
#[ORM\Table(name: 'gpd_survey_section_item', indexes: [
    new ORM\Index(name: 'user_created_idx', columns: ['created']),
    new ORM\Index(name: 'user_updated_idx', columns: ['updated']),
])]
class SurveySectionItem  extends AbstractEntityModelUlid
{
    const RELATIONS_MANY_TO_ONE = ['conditions', 'section', 'question', 'content'];

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', name: 'item_type', nullable: false)]
    private $type;
    /**
     * @var int
     */
    #[ORM\Column(type: 'integer', name: 'order_number', nullable: false)]
    private $order;
    /**
     * @var SurveyConfiguration
     */
    #[ORM\ManyToOne(targetEntity: SurveyConfiguration::class)]
    #[ORM\JoinColumn(name: 'condition_id', referencedColumnName: 'id', nullable: true)]
    private $conditions;
    /**
     *
     * @var SurveyQuestion
     */
    #[ORM\OneToOne(targetEntity: SurveyQuestion::class)]
    #[ORM\JoinColumn(name: 'question_id', referencedColumnName: 'id', nullable: true)]
    private $question;
    /**
     *
     * @var SurveyContent
     */
    #[ORM\OneToOne(targetEntity: SurveyContent::class)]
    #[ORM\JoinColumn(name: 'content_id', referencedColumnName: 'id', nullable: true)]
    private $content;

    /**
     * 
     * @var SurveySection
     */
    #[ORM\ManyToOne(targetEntity: SurveySection::class, inversedBy: 'items')]
    #[ORM\JoinColumn(name: 'section_id', referencedColumnName: 'id', nullable: false)]
    private $section;
    /**
     * @var bool
     */
    #[ORM\Column(type: 'boolean', name: 'hidden', nullable: false, options: ['default' => 0])]
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
