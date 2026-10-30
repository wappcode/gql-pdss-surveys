<?php

namespace GPDSurvey\Infrastructure\Doctrine\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use PDSSUtilities\AbstractEntityModelUlid;

#[ORM\Entity]
#[ORM\Table(
    name: 'gpd_survey_question',
    indexes: [
        new ORM\Index(name: 'user_created_idx', columns: ['created']),
        new ORM\Index(name: 'user_updated_idx', columns: ['updated']),
    ],
    uniqueConstraints: [
        new ORM\UniqueConstraint(name: 'question_survey_code', columns: ['survey_id', 'code']),
    ]
)]
class DoctrineSurveyQuestion extends AbstractEntityModelUlid
{


    #[ORM\Column(type: 'string', length: 5000, name: 'title', nullable: false)]
    private string $title;

    #[ORM\Column(type: 'string', name: 'code', nullable: false)]
    private string $code;

    #[ORM\Column(type: 'string', name: 'question_type', nullable: false)]
    private string $type;

    #[ORM\Column(type: 'boolean', name: 'required', nullable: false, options: ['default' => 1])]
    private bool $required;

    #[ORM\Column(type: 'boolean', name: 'other', nullable: false, options: ['default' => 0])]
    private bool $other;

    #[ORM\ManyToOne(targetEntity: DoctrineSurveyContent::class)]
    #[ORM\JoinColumn(name: 'question_hint', referencedColumnName: 'id', nullable: true)]
    private ?DoctrineSurveyContent $hint;

    #[ORM\OneToMany(targetEntity: DoctrineSurveyQuestionOption::class, mappedBy: 'question')]
    private Collection $options;

    #[ORM\ManyToOne(targetEntity: DoctrineSurveyContent::class)]
    #[ORM\JoinColumn(name: 'content_id', referencedColumnName: 'id', nullable: true)]
    private ?DoctrineSurveyContent $content;

    #[ORM\ManyToOne(targetEntity: DoctrineSurveyConfiguration::class)]
    #[ORM\JoinColumn(name: 'presentation_id', referencedColumnName: 'id', nullable: true)]
    private ?DoctrineSurveyConfiguration $presentation;

    #[ORM\ManyToOne(targetEntity: DoctrineSurveyConfiguration::class)]
    #[ORM\JoinColumn(name: 'validators_id', referencedColumnName: 'id', nullable: true)]
    private ?DoctrineSurveyConfiguration $validators;

    #[ORM\OneToOne(targetEntity: DoctrineSurveyConfiguration::class)]
    #[ORM\JoinColumn(name: 'answer_score_id', referencedColumnName: 'id', nullable: true)]
    private ?DoctrineSurveyConfiguration $answerScore;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 4, nullable: true)]
    private ?float $score;

    #[ORM\ManyToOne(targetEntity: DoctrineSurvey::class, inversedBy: 'questions')]
    #[ORM\JoinColumn(name: 'survey_id', referencedColumnName: 'id', nullable: false)]
    private DoctrineSurvey $survey;

    #[ORM\Column(type: 'datetimetz_immutable', name: 'created', nullable: false)]
    protected \DateTimeImmutable $created;

    #[ORM\Column(type: 'datetimetz_immutable', name: 'updated', nullable: false)]
    protected \DateTimeImmutable $updated;

    public function __construct()
    {
        parent::__construct();
        $this->options = new ArrayCollection();
        $this->score = 1;
        $this->other = false;
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
     * Get the value of code
     *
     * @return  string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set the value of code
     *
     * @param  string  $code
     *
     * @return  self
     */
    public function setCode(string $code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get the value of type
     * @return  string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     * CHECKBOX_LIST
     * DATE
     * DATE_RANGE
     * DATETIME
     * EMAIL
     * FILE
     * IMAGE
     * NUMBER
     * NUMBER_LIST
     * ONE_LINE_TEXT
     * PHONE
     * RADIO_LIST
     * SHORT_TEXT
     *
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
     * Get the value of required
     *
     * @return  bool
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * Set the value of required
     *
     * @param  bool  $required
     *
     * @return  self
     */
    public function setRequired(bool $required)
    {
        $this->required = $required;

        return $this;
    }

    /**
     * Get the value of other
     *
     * @return  bool
     */
    public function getOther()
    {
        return $this->other;
    }

    /**
     * Set the value of other
     *
     * @param  bool  $other
     *
     * @return  self
     */
    public function setOther(bool $other = false)
    {
        $this->other = $other;

        return $this;
    }





    /**
     * Get the value of options
     *
     * @return  Collection
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function setOptions(Collection $options): self
    {
        $this->options = $options;

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
     * Objeto DoctrineSurveyConfiguration que tiene los puntajes por respuesta
     * @return  ?DoctrineSurveyConfiguration
     */
    public function getAnswerScore()
    {
        return $this->answerScore;
    }

    /**
     * Establece el objeto SurveyConfiguration que tiene los puntajes por respuesta
     * @param  ?DoctrineSurveyConfiguration  $answerScore  
     *
     * @return  self
     */
    public function setAnswerScore(?DoctrineSurveyConfiguration $answerScore)
    {
        $this->answerScore = $answerScore;

        return $this;
    }

    /**
     * Get the value of score
     * @return ?float
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set the value of score
     *
     * @return  self
     */
    public function setScore(?float $score)
    {
        $this->score = $score;

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
     * Get the value of validators
     *
     * @return  ?DoctrineSurveyConfiguration
     */
    public function getValidators()
    {
        return $this->validators;
    }

    /**
     * Set the value of validators
     *
     * @param  ?DoctrineSurveyConfiguration  $validators
     *
     * @return  self
     */
    public function setValidators(?DoctrineSurveyConfiguration $validators)
    {
        $this->validators = $validators;

        return $this;
    }

    /**
     * Get the value of hint
     *
     * @return  ?DoctrineSurveyContent
     */
    public function getHint()
    {
        return $this->hint;
    }

    /**
     * Set the value of hint
     *
     * @param  ?DoctrineSurveyContent  $hint
     *
     * @return  self
     */
    public function setHint(?DoctrineSurveyContent $hint)
    {
        $this->hint = $hint;

        return $this;
    }
}
