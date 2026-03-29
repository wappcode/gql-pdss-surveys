<?php

namespace GPDSurvey\Entities;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use GPDSurvey\Entities\Survey;
use Doctrine\ORM\Mapping as ORM;
use GPDSurvey\Entities\SurveyContent;

use GPDSurvey\Entities\SurveyConfiguration;
use PDSSUtilities\AbstractEntityModelUlid;

/**
 * Doctrine Entity For SurveyTargetAudience
 */
#[ORM\Entity]
#[ORM\Table(name: 'gpd_survey_target_audience', indexes: [
    new ORM\Index(name: 'user_created_idx', columns: ['created']),
    new ORM\Index(name: 'user_updated_idx', columns: ['updated']),
])]
class SurveyTargetAudience  extends AbstractEntityModelUlid
{
    const RELATIONS_MANY_TO_ONE = ['welcome', 'farewell', 'survey', 'presentation'];
    /**
     * @var string
     */
    #[ORM\Column(type: 'string', name: 'title', nullable: false)]
    private $title;
    /**
     * @var DateTimeInterface
     */
    #[ORM\Column(type: 'datetimetz_immutable', name: 'starts', nullable: true)]
    private $starts;
    /**
     * @var DateTimeInterface
     */
    #[ORM\Column(type: 'datetimetz_immutable', name: 'ends', nullable: true)]
    private $ends;

    /**
     * @var ?SurveyContent
     */
    #[ORM\ManyToOne(targetEntity: SurveyContent::class)]
    #[ORM\JoinColumn(name: 'welcome_content_id', referencedColumnName: 'id', nullable: true)]
    private $welcome;
    /**
     * @var ?SurveyContent
     */
    #[ORM\ManyToOne(targetEntity: SurveyContent::class)]
    #[ORM\JoinColumn(name: 'farewell_content_id', referencedColumnName: 'id', nullable: true)]
    private $farewell;
    /**
     * @var int
     */
    #[ORM\Column(type: 'integer', name: 'attempts', nullable: true)]
    private $attempts;

    /**
     * @var Survey
     */
    #[ORM\ManyToOne(targetEntity: Survey::class, inversedBy: 'targetAudiences')]
    #[ORM\JoinColumn(name: 'survey_id', referencedColumnName: 'id', nullable: false)]
    private $survey;

    /**
     *
     * @var ?SurveyConfiguration
     * 
     */
    #[ORM\ManyToOne(targetEntity: SurveyConfiguration::class)]
    #[ORM\JoinColumn(name: 'presentation_id', referencedColumnName: 'id', nullable: true)]
    private $presentation;
    //TODO agregar seguridad para consultas de targetAudience no debe retornar información si tiene asignado un password
    /**
     * @var ?string
     */
    #[ORM\Column(type: 'string', length: 255, nullable: true, name: 'audience_password')]
    private $password;

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
     * Get the value of starts
     * @API\Field(type="?DateTime")
     * @return  ?DateTime
     */
    public function getStarts()
    {
        return $this->starts;
    }

    /**
     * Set the value of starts
     * @API\Input(type="?DateTime")
     * @param  DateTime  $starts
     *
     * @return  self
     */
    public function setStarts(?DateTimeInterface $starts)
    {
        $immutable = new DateTimeImmutable($starts->format('c'));
        $this->starts = $immutable;

        return $this;
    }

    /**
     * Get the value of ends
     * @API\Field(type="?DateTime")
     * @return  ?DateTime
     */
    public function getEnds()
    {
        return $this->ends;
    }

    /**
     * Set the value of ends
     * @API\Input(type="?DateTime")
     * @param  DateTime  $ends
     *
     * @return  self
     */
    public function setEnds(?DateTimeInterface $ends)
    {
        $immutable = new DateTimeImmutable($ends->format('c'));
        $this->ends = $immutable;

        return $this;
    }

    /**
     * Get the value of welcome
     *
     * @return  ?\GPDSurvey\Entities\SurveyContent
     */
    public function getWelcome()
    {
        return $this->welcome;
    }

    /**
     * Set the value of welcome
     *
     * @param  ?SurveyContent  $welcome
     *
     * @return  self
     */
    public function setWelcome(?SurveyContent $welcome)
    {
        $this->welcome = $welcome;

        return $this;
    }

    /**
     * Get the value of farewell
     *
     * @return  ?\GPDSurvey\Entities\SurveyContent
     */
    public function getFarewell()
    {
        return $this->farewell;
    }

    /**
     * Set the value of farewell
     *
     * @param  ?SurveyContent  $farewell
     *
     * @return  self
     */
    public function setFarewell(?SurveyContent $farewell)
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
     * Get the value of password
     * @API\Exclude
     * @return  ?string
     */
    public function getPassword()
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
