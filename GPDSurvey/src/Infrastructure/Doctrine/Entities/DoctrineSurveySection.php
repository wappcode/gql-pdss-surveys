<?php

namespace GPDSurvey\Infrastructure\Doctrine\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use PDSSUtilities\AbstractEntityModelUlid;

#[ORM\Entity]
#[ORM\Table(
    name: 'gpd_survey_section',
    indexes: [
        new ORM\Index(name: 'user_created_idx', columns: ['created']),
        new ORM\Index(name: 'user_updated_idx', columns: ['updated']),
    ]
)]
class DoctrineSurveySection extends AbstractEntityModelUlid
{


    #[ORM\Column(type: 'string', name: 'title', nullable: false)]
    private string $title;

    #[ORM\ManyToOne(targetEntity: DoctrineSurveyContent::class)]
    #[ORM\JoinColumn(name: 'content_id', referencedColumnName: 'id', nullable: true)]
    private ?DoctrineSurveyContent $content;

    #[ORM\OneToMany(targetEntity: DoctrineSurveySectionItem::class, mappedBy: 'section')]
    private Collection $items;

    #[ORM\Column(type: 'integer', name: 'order_number', nullable: false)]
    private int $order;

    #[ORM\Column(type: 'boolean', name: 'hidden', nullable: false, options: ['default' => 0])]
    private bool $hidden;

    #[ORM\ManyToOne(targetEntity: DoctrineSurveyConfiguration::class)]
    #[ORM\JoinColumn(name: 'presentation_id', referencedColumnName: 'id', nullable: true)]
    private ?DoctrineSurveyConfiguration $presentation;

    #[ORM\ManyToOne(targetEntity: DoctrineSurvey::class, inversedBy: 'sections')]
    #[ORM\JoinColumn(name: 'survey_id', referencedColumnName: 'id', nullable: false)]
    private DoctrineSurvey $survey;

    #[ORM\Column(type: 'datetimetz_immutable', name: 'created', nullable: false)]
    protected \DateTimeImmutable $created;

    #[ORM\Column(type: 'datetimetz_immutable', name: 'updated', nullable: false)]
    protected \DateTimeImmutable $updated;

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
     * Get the value of items
     *
     * @return  Collection
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function setItems(Collection $items): self
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
     * Get the value of survey
     *
     * @return  DoctrineSurvey
     */
    public function getSurvey()
    {
        return $this->survey;
    }

    /**
     * Set the value of survey
     *
     * @param  DoctrineSurvey  $survey
     *
     * @return  self
     */
    public function setSurvey(DoctrineSurvey $survey)
    {
        $this->survey = $survey;

        return $this;
    }
}
