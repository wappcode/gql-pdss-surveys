<?php

namespace GPDSurvey\Entities;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;
use PDSSUtilities\AbstractEntityModelUlid;

/**
 * Doctrine Entity For SurveyAnswerSession
 */
#[ORM\Entity]
#[ORM\Table(name: 'gpd_survey_answer_session', indexes: [
    new ORM\Index(name: 'user_created_idx', columns: ['created']),
    new ORM\Index(name: 'user_updated_idx', columns: ['updated']),
], uniqueConstraints: [
    new ORM\UniqueConstraint(name: 'username', columns: ['target_audience_id', 'username']),
])]
class SurveyAnswerSession  extends AbstractEntityModelUlid
{
    const RELATIONS_MANY_TO_ONE = ['targetAudience', 'survey'];
    /**
     * @var ?string
     */
    #[ORM\Column(type: 'string', length: 500, name: 'name', nullable: true)]
    private $name;
    /**
     * @var ?string
     */
    #[ORM\Column(type: 'string', length: 500, name: 'username', nullable: true)]
    private $username;
    /**
     * @var ?string
     */
    #[ORM\Column(type: 'string', length: 500, name: 'session_password', nullable: true)]
    private $password;
    /**
     * Extern reference to the owner 
     * Can be many for the same Target Audience
     * @var ?string
     */
    #[ORM\Column(type: 'string', length: 500, name: 'owner_code', nullable: true)]
    private $ownerCode;
    /**
     *
     * @var ?float
     */
    #[ORM\Column(type: 'decimal', name: 'score', precision: 10, scale: 4, nullable: true)]
    private $score;
    /**
     *
     * @var bool
     */
    #[ORM\Column(type: 'boolean', name: 'completed', options: ['default' => 0])]
    private $completed;
    /**
     *
     * @var ?float
     */
    #[ORM\Column(type: 'decimal', name: 'score_percent', precision: 8, scale: 4, nullable: true)]
    private $scorePercent;
    /**
     * @var Collection
     */
    #[ORM\OneToMany(targetEntity: SurveyAnswer::class, mappedBy: 'session')]
    private $answers;

    /**
     *
     * @var SurveyTargetAudience
     */
    #[ORM\ManyToOne(targetEntity: SurveyTargetAudience::class)]
    #[ORM\JoinColumn(name: 'target_audience_id', referencedColumnName: 'id', nullable: false)]
    private $targetAudience;
    /**
     * @var Survey
     */
    #[ORM\ManyToOne(targetEntity: Survey::class)]
    #[ORM\JoinColumn(name: 'survey_id', referencedColumnName: 'id', nullable: false)]
    private $survey;

    public function __construct()
    {
        parent::__construct();
        $this->answers = new ArrayCollection();
        $this->completed = false;
    }

    /**
     * Get the value of name
     *
     * @return  ?string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param  ?string  $name
     *
     * @return  self
     */
    public function setName(?string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of username
     *
     * @return  ?string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @param  ?string  $username
     *
     * @return  self
     */
    public function setUsername(?string $username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of password
     *
     * @Api\Exclude
     * @return  ?string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @param  ?string  $password
     *
     * @return  self
     */
    public function setPassword(?string $password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the extern reference to the owner 
     *
     * @return  ?string
     */
    public function getOwnerCode()
    {
        return $this->ownerCode;
    }

    /**
     * Set the extern reference to the owner 
     *
     * @param  ?string  $ownerCode
     *
     * @return  self
     */
    public function setOwnerCode(?string $ownerCode)
    {
        $this->ownerCode = $ownerCode;

        return $this;
    }

    /**
     * Get the value of score
     *
     * @return  ?float
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @param  ?float  $score
     *
     * @return  self
     */
    public function setScore(?float $score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * 
     *
     * @return  ?float
     */
    public function getScorePercent()
    {
        return $this->scorePercent;
    }

    /**
     *
     * @param  ?float  $scorePercent
     *
     * @return  self
     */
    public function setScorePercent(?float $scorePercent)
    {
        $this->scorePercent = $scorePercent;

        return $this;
    }

    /**
     * Get the value of answers
     *
     * @return  Collection
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    /**
     * Set the value of answers
     *
     * @API\Input(type="?GPDSurvey\Graphql\Types\TypeSurveyAnswerQuestionInput[]")
     * @param  Collection  $answers
     *
     * @return  self
     */
    public function setAnswers(Collection $answers)
    {
        $this->answers = $answers;

        return $this;
    }

    /**
     * Get the value of targetAudience
     *
     * @return  SurveyTargetAudience
     */
    public function getTargetAudience()
    {
        return $this->targetAudience;
    }

    /**
     * Set the value of targetAudience
     *
     * @API\Input(type="id")
     * @param  SurveyTargetAudience  $targetAudience
     *
     * @return  self
     */
    public function setTargetAudience(SurveyTargetAudience $targetAudience)
    {
        $this->targetAudience = $targetAudience;

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
     * @API\Exclude()
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
     * Get the value of completed
     *
     * @return  bool
     */
    public function getCompleted()
    {
        return $this->completed;
    }

    /**
     * Set the value of completed
     *
     * @param  bool  $completed
     *
     * @return  self
     */
    public function setCompleted(bool $completed = false)
    {
        $this->completed = $completed;

        return $this;
    }
}
