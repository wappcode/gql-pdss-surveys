<?php

namespace GPDSurvey\Entities;

use GPDSurvey\Entities\SurveyContent;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use PDSSUtilities\AbstractEntityModelUlid;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Doctrine Entity For SurveySection
 * No se agregar indice único relacionado con el orden podria ocacionar conflictos en el procesos build
 */
#[ORM\Entity]
#[ORM\Table(name: 'gpd_survey_section', indexes: [
    new ORM\Index(name: 'user_created_idx', columns: ['created']),
    new ORM\Index(name: 'user_updated_idx', columns: ['updated']),
])]
class SurveySection  extends AbstractEntityModelUlid
{
    const RELATIONS_MANY_TO_ONE = ['survey', 'content', 'presentation'];
    /**
     * @var string
     */
    #[ORM\Column(type: 'string', name: 'title', nullable: false)]
    private $title;
    /**
     * @var SurveyContent
     */
    #[ORM\ManyToOne(targetEntity: SurveyContent::class)]
    #[ORM\JoinColumn(name: 'content_id', referencedColumnName: 'id', nullable: true)]
    private $content;
    /**
     * 
     * @var Collection
     */
    #[ORM\OneToMany(targetEntity: SurveySectionItem::class, mappedBy: 'section')]
    private $items;
    /**
     * @var int
     */
    #[ORM\Column(type: 'integer', name: 'order_number', nullable: false)]
    private $order;

    /**
     * Este valor no se registra dentro del valor presentation porque se utiliza para determinar que preguntas obligatorias no se han contestado
     * 
     * @var bool
     */
    #[ORM\Column(type: 'boolean', name: 'hidden', nullable: false, options: ['default' => 0])]
    private $hidden;

    /**
     *
     * @var SurveyConfiguration
     * 
     */
    #[ORM\ManyToOne(targetEntity: SurveyConfiguration::class)]
    #[ORM\JoinColumn(name: 'presentation_id', referencedColumnName: 'id', nullable: true)]
    private $presentation;

    /**
     * 
     * @var Survey
     */
    #[ORM\ManyToOne(targetEntity: Survey::class, inversedBy: 'sections')]
    #[ORM\JoinColumn(name: 'survey_id', referencedColumnName: 'id', nullable: false)]
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
    public function setHidden(bool $hidden)
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
