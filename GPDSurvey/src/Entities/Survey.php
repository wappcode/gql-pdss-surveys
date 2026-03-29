<?php

namespace GPDSurvey\Entities;

use Doctrine\Common\Collections\Collection;
use PDSSUtilities\AbstractEntityModelUlid;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

/**
 * Doctrine Entity For Survey
 */
#[ORM\Entity]
#[ORM\Table(name: 'gpd_survey', indexes: [
    new ORM\Index(name: 'user_created_idx', columns: ['created']),
    new ORM\Index(name: 'user_updated_idx', columns: ['updated']),
])]
class Survey  extends AbstractEntityModelUlid
{
    const RELATIONS_MANY_TO_ONE = [];
    /**
     * @var string
     */
    #[ORM\Column(type: 'string', name: 'title', nullable: false)]
    private $title;
    /**
     *
     * @var Collection
     */
    #[ORM\OneToMany(targetEntity: SurveyTargetAudience::class, mappedBy: 'survey')]
    private $targetAudiences;
    /**
     *
     * @var Collection
     */
    #[ORM\OneToMany(targetEntity: SurveyQuestion::class, mappedBy: 'survey')]
    private $questions;
    /**
     *
     * @var Collection
     */
    #[ORM\OneToMany(targetEntity: SurveySection::class, mappedBy: 'survey')]
    private $sections;

    //TODO: Configurar para que no se puedan agregar respuestas en una encuesta activa
    /**
     * @var bool
     */
    #[ORM\Column(name: 'active', type: 'boolean', nullable: false, options: ['default' => 0])]
    private $active;

    public function __construct()
    {
        parent::__construct();
        $this->targetAudiences = new ArrayCollection();
        $this->questions = new ArrayCollection();
        $this->sections = new ArrayCollection();
        $this->active = true;
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
     * Get the value of targetAudiences
     *
     * @return  Collection
     */
    public function getTargetAudiences(): Collection
    {
        return $this->targetAudiences;
    }

    /**
     * Set the value of targetAudiences
     *
     * @API\Exclude
     * @param  Collection  $targetAudiences
     *
     * @return  self
     */
    public function setTargetAudiences(Collection $targetAudiences)
    {
        $this->targetAudiences = $targetAudiences;

        return $this;
    }

    /**
     * Get the value of questions
     *
     * @return  Collection
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    /**
     * Set the value of questions
     * @API\Exclude
     * @param  Collection  $questions
     *
     * @return  self
     */
    public function setQuestions(Collection $questions)
    {
        $this->questions = $questions;

        return $this;
    }

    /**
     * Get the value of sections
     *
     * @return  Collection
     */
    public function getSections(): Collection
    {
        return $this->sections;
    }

    /**
     * Set the value of sections
     *
     * @API\Exclude
     * @param  Collection  $sections
     * 
     * @return  self
     */
    public function setSections(Collection $sections)
    {
        $this->sections = $sections;

        return $this;
    }

    /**
     * Get the value of active
     *
     * @return  bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set the value of active
     *
     * @param  bool  $active
     *
     * @return  self
     */
    public function setActive(bool $active)
    {
        $this->active = $active;

        return $this;
    }
}
