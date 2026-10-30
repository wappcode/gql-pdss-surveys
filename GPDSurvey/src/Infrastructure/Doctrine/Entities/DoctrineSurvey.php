<?php

namespace GPDSurvey\Infrastructure\Doctrine\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use PDSSUtilities\AbstractEntityModelUlid;

#[ORM\Entity]
#[ORM\Table(
    name: 'gpd_survey',
    indexes: [
        new ORM\Index(name: 'user_created_idx', columns: ['created']),
        new ORM\Index(name: 'user_updated_idx', columns: ['updated']),
    ]
)]
class DoctrineSurvey extends AbstractEntityModelUlid
{


    #[ORM\Column(type: 'string', name: 'title', nullable: false)]
    private string $title;

    #[ORM\OneToMany(targetEntity: DoctrineSurveyTargetAudience::class, mappedBy: 'survey')]
    private Collection $targetAudiences;

    #[ORM\OneToMany(targetEntity: DoctrineSurveyQuestion::class, mappedBy: 'survey')]
    private Collection $questions;

    #[ORM\OneToMany(targetEntity: DoctrineSurveySection::class, mappedBy: 'survey')]
    private Collection $sections;

    //TODO: Configurar para que no se puedan agregar respuestas en una encuesta activa
    #[ORM\Column(name: 'active', type: 'boolean', nullable: false, options: ['default' => 0])]
    private bool $active;

    #[ORM\Column(type: 'datetimetz_immutable', name: 'created', nullable: false)]
    protected \DateTimeImmutable $created;

    #[ORM\Column(type: 'datetimetz_immutable', name: 'updated', nullable: false)]
    protected \DateTimeImmutable $updated;

    public function __construct()
    {
        parent::__construct();
        $this->targetAudiences = new ArrayCollection();
        $this->questions = new ArrayCollection();
        $this->sections = new ArrayCollection();
        $this->active = true;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTargetAudiences(): Collection
    {
        return $this->targetAudiences;
    }

    public function setTargetAudiences(Collection $targetAudiences): self
    {
        $this->targetAudiences = $targetAudiences;

        return $this;
    }

    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function setQuestions(Collection $questions): self
    {
        $this->questions = $questions;

        return $this;
    }

    public function getSections(): Collection
    {
        return $this->sections;
    }

    public function setSections(Collection $sections): self
    {
        $this->sections = $sections;

        return $this;
    }

    public function getActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }
}
