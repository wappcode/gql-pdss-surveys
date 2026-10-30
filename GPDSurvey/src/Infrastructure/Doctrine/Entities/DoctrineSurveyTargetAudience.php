<?php

namespace GPDSurvey\Infrastructure\Doctrine\Entities;

use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use PDSSUtilities\AbstractEntityModelUlid;

#[ORM\Entity]
#[ORM\Table(
    name: 'gpd_survey_target_audience',
    indexes: [
        new ORM\Index(name: 'user_created_idx', columns: ['created']),
        new ORM\Index(name: 'user_updated_idx', columns: ['updated']),
    ]
)]
class DoctrineSurveyTargetAudience extends AbstractEntityModelUlid
{


    #[ORM\Column(type: 'string', name: 'title', nullable: false)]
    private string $title;

    #[ORM\Column(type: 'datetimetz_immutable', name: 'starts', nullable: true)]
    private ?DateTimeInterface $starts;

    #[ORM\Column(type: 'datetimetz_immutable', name: 'ends', nullable: true)]
    private ?DateTimeInterface $ends;

    #[ORM\ManyToOne(targetEntity: DoctrineSurveyContent::class)]
    #[ORM\JoinColumn(name: 'welcome_content_id', referencedColumnName: 'id', nullable: true)]
    private ?DoctrineSurveyContent $welcome;

    #[ORM\ManyToOne(targetEntity: DoctrineSurveyContent::class)]
    #[ORM\JoinColumn(name: 'farewell_content_id', referencedColumnName: 'id', nullable: true)]
    private ?DoctrineSurveyContent $farewell;

    #[ORM\Column(type: 'integer', name: 'attempts', nullable: true)]
    private ?int $attempts;

    #[ORM\ManyToOne(targetEntity: DoctrineSurvey::class, inversedBy: 'targetAudiences')]
    #[ORM\JoinColumn(name: 'survey_id', referencedColumnName: 'id', nullable: false)]
    private DoctrineSurvey $survey;

    #[ORM\ManyToOne(targetEntity: DoctrineSurveyConfiguration::class)]
    #[ORM\JoinColumn(name: 'presentation_id', referencedColumnName: 'id', nullable: true)]
    private ?DoctrineSurveyConfiguration $presentation;

    //TODO agregar seguridad para consultas de targetAudience no debe retornar información si tiene asignado un password
    #[ORM\Column(type: 'string', length: 255, nullable: true, name: 'audience_password')]
    private ?string $password;

    #[ORM\Column(type: 'datetimetz_immutable', name: 'created', nullable: false)]
    protected \DateTimeImmutable $created;

    #[ORM\Column(type: 'datetimetz_immutable', name: 'updated', nullable: false)]
    protected \DateTimeImmutable $updated;

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

    public function getStarts(): ?DateTimeInterface
    {
        return $this->starts;
    }

    public function setStarts(?DateTimeInterface $starts): self
    {
        $immutable = new DateTimeImmutable($starts->format('c'));
        $this->starts = $immutable;

        return $this;
    }

    public function getEnds(): ?DateTimeInterface
    {
        return $this->ends;
    }

    public function setEnds(?DateTimeInterface $ends): self
    {
        $immutable = new DateTimeImmutable($ends->format('c'));
        $this->ends = $immutable;

        return $this;
    }

    /**
     * Get the value of welcome
     *
     * @return  ?\GPDSurvey\Infrastructure\Doctrine\Entities\DoctrineSurveyContent
     */
    public function getWelcome()
    {
        return $this->welcome;
    }

    /**
     * Set the value of welcome
     *
     * @param  ?DoctrineSurveyContent  $welcome
     *
     * @return  self
     */
    public function setWelcome(?DoctrineSurveyContent $welcome)
    {
        $this->welcome = $welcome;

        return $this;
    }

    /**
     * Get the value of farewell
     *
     * @return  ?DoctrineSurveyContent
     */
    public function getFarewell()
    {
        return $this->farewell;
    }

    /**
     * Set the value of farewell
     *
     * @param  ?DoctrineSurveyContent  $farewell
     *
     * @return  self
     */
    public function setFarewell(?DoctrineSurveyContent $farewell)
    {
        $this->farewell = $farewell;

        return $this;
    }

    /**
     * Get the value of attempts
     *
     * @return  ?int
     */
    public function getAttempts()
    {
        return $this->attempts;
    }

    /**
     * Set the value of attempts
     *
     * @param  ?int  $attempts
     *
     * @return  self
     */
    public function setAttempts(?int $attempts)
    {
        $this->attempts = $attempts;

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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Set the value of password
     * @param  ?string  $password
     *
     * @return  self
     */
    public function setPassword(?string $password)
    {
        $this->password = $password;

        return $this;
    }
}
