<?php

namespace GPDSurvey\Infrastructure\Doctrine\Entities;

use Doctrine\ORM\Mapping as ORM;
use PDSSUtilities\AbstractEntityModelUlid;

#[ORM\Entity]
#[ORM\Table(
    name: 'gpd_survey_section_item',
    indexes: [
        new ORM\Index(name: 'user_created_idx', columns: ['created']),
        new ORM\Index(name: 'user_updated_idx', columns: ['updated']),
    ]
)]
class DoctrineSurveySectionItem extends AbstractEntityModelUlid
{


    #[ORM\Column(type: 'string', name: 'item_type', nullable: false)]
    private string $type;

    #[ORM\Column(type: 'integer', name: 'order_number', nullable: false)]
    private int $order;

    #[ORM\ManyToOne(targetEntity: DoctrineSurveyConfiguration::class)]
    #[ORM\JoinColumn(name: 'condition_id', referencedColumnName: 'id', nullable: true)]
    private ?DoctrineSurveyConfiguration $conditions;

    #[ORM\OneToOne(targetEntity: DoctrineSurveyQuestion::class)]
    #[ORM\JoinColumn(name: 'question_id', referencedColumnName: 'id', nullable: true)]
    private ?DoctrineSurveyQuestion $question;

    #[ORM\OneToOne(targetEntity: DoctrineSurveyContent::class)]
    #[ORM\JoinColumn(name: 'content_id', referencedColumnName: 'id', nullable: true)]
    private ?DoctrineSurveyContent $content;

    #[ORM\ManyToOne(targetEntity: DoctrineSurveySection::class, inversedBy: 'items')]
    #[ORM\JoinColumn(name: 'section_id', referencedColumnName: 'id', nullable: false)]
    private DoctrineSurveySection $section;

    #[ORM\Column(type: 'boolean', name: 'hidden', nullable: false, options: ['default' => 0])]
    private bool $hidden;

    #[ORM\Column(type: 'datetimetz_immutable', name: 'created', nullable: false)]
    protected \DateTimeImmutable $created;

    #[ORM\Column(type: 'datetimetz_immutable', name: 'updated', nullable: false)]
    protected \DateTimeImmutable $updated;


    public function __construct()
    {
        parent::__construct();
        $this->hidden = false;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
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
     * @return  ?DoctrineSurveyConfiguration
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * Set the value of conditions
     *
     * @param  ?DoctrineSurveyConfiguration  $conditions
     *
     * @return  self
     */
    public function setConditions(?DoctrineSurveyConfiguration $conditions)
    {
        $this->conditions = $conditions;

        return $this;
    }

    /**
     * Get the value of question
     *
     * @return  ?DoctrineSurveyQuestion
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set the value of question
     *
     * @param  ?DoctrineSurveyQuestion  $question
     *
     * @return  self
     */
    public function setQuestion(?DoctrineSurveyQuestion $question)
    {
        $this->question = $question;

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
     * Get the value of section
     *
     * @return  DoctrineSurveySection
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * Set the value of section
     *
     * @param  DoctrineSurveySection  $section
     *
     * @return  self
     */
    public function setSection(DoctrineSurveySection $section)
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
