<?php

namespace GPDSurvey\Entities;

use GPDSurvey\Entities\Survey;
use Doctrine\Common\Collections\Collection;
use GPDCore\Entities\AbstractEntityModelStringId;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use GraphQL\Doctrine\Annotation as API;

/**
 * Doctrine Entity For SurveyQuestion
 * @ORM\Entity()
 * @ORM\Table(name="gpd_survey_question", indexes={
 * @ORM\Index(name="user_created_idx",columns={"created"}),
 * @ORM\Index(name="user_updated_idx",columns={"updated"})
 * },
 * uniqueConstraints ={
 * @ORM\UniqueConstraint(name="question_survey_code", 
 *            columns={"survey_id","code"})
 * }
 * )
 * 
 */
class SurveyQuestion  extends AbstractEntityModelStringId
{

    const RELATIONS_MANY_TO_ONE = ['survey', 'answerScore', 'content', 'presentation', 'validators'];


    /**
     * @ORM\Column(type="string", length=5000, name="title", nullable=false) 
     * @var string
     */
    private $title;

    /**
     * @ORM\Column(type="string", name="code", nullable=false) 
     * @var string
     */
    private $code;
    /**
     * @ORM\Column(type="string", name="type", nullable=false) 
     * @var string
     */
    private $type;
    /**
     * @ORM\Column(type="boolean", name="required", nullable=false, options={"default":1}) 
     * @var bool
     */
    private $required;
    /**
     * @ORM\Column(type="boolean", name="other", nullable=false, options={"default":0}) 
     * @var bool
     */
    private $other;

    /**
     * 
     * @ORM\Column(type="string", name="hint", nullable=true) 
     * @var string
     */
    private $hint;
    /**
     *
     * @ORM\OneToMany(targetEntity="\GPDSurvey\Entities\SurveyQuestionOption", mappedBy="question")
     * @var Collection
     */
    private $options;
    /**
     *
     * @ORM\ManyToOne(targetEntity="\GPDSurvey\Entities\SurveyContent")
     * @ORM\JoinColumn(name="content_id", referencedColumnName="id", nullable=true)
     * @var SurveyContent
     */
    private $content;
    /**
     *
     * @ORM\OneToOne(targetEntity="\GPDSurvey\Entities\SurveyConfiguration")
     * @ORM\JoinColumn(name="presentation_id", referencedColumnName="id", nullable=true)
     * @var SurveyConfiguration
     * 
     */
    private $presentation;
    /**
     *
     * @ORM\OneToOne(targetEntity="\GPDSurvey\Entities\SurveyConfiguration")
     * @ORM\JoinColumn(name="validators_id", referencedColumnName="id", nullable=true)
     * @var SurveyConfiguration
     * 
     */
    private $validators;
    /**
     *
     * Si hay valor en este registro se considera que se debe calificar y asignar puntaje y porcentaje
     * 
     * @ORM\OneToOne(targetEntity="\GPDSurvey\Entities\SurveyConfiguration")
     * @ORM\JoinColumn(name="answer_score_id", referencedColumnName="id", nullable=true)
     * @var SurveyConfiguration
     */
    private $answerScore;
    /**
     *
     * Se establece como valor predeterminado 1 para poder calcular el puntaje máximo de la encuesta.
     * También puede servir para asignar puntaje de forma manual mediante un formulario para cada respuesta.
     * 
     * @ORM\Column(type="decimal", precision=10, scale=4, nullable=false, options={"default":1})
     */
    private $score;
    /**
     *
     * @ORM\ManyToOne(targetEntity="\GPDSurvey\Entities\Survey", inversedBy="questions")
     * @ORM\JoinColumn(name="survey_id", referencedColumnName="id", nullable=false)
     * @var Survey
     */
    private $survey;

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
     * @API\Field(type="GPDSurvey\Graphql\Types\TypeSurveyQuestionType")
     * @return  string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @API\Input(type="GPDSurvey\Graphql\Types\TypeSurveyQuestionType")
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
     * Get the value of hint
     *
     * @return  ?string
     */
    public function getHint()
    {
        return $this->hint;
    }

    /**
     * Set the value of hint
     *
     * @param  string  $hint
     *
     * @return  self
     */
    public function setHint(?string $hint)
    {
        $this->hint = $hint;

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

    /**
     * Set the value of options
     *
     * @API\Exclude
     * @param  Collection  $options
     *
     * @return  self
     */
    public function setOptions(Collection $options)
    {
        $this->options = $options;

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
     * @param  SurveyContent  $content
     *
     * @return  self
     */
    public function setContent(?SurveyContent $content)
    {
        $this->content = $content;

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
     * @param  SurveyConfiguration  $presentation
     *
     * @return  self
     */
    public function setPresentation(?SurveyConfiguration $presentation)
    {
        $this->presentation = $presentation;

        return $this;
    }

    /**
     *
     * @return  ?SurveyConfiguration
     */
    public function getAnswerScore()
    {
        return $this->answerScore;
    }

    /**
     *
     * @param  ?SurveyConfiguration  $answerScore  
     *
     * @return  self
     */
    public function setAnswerScore(?SurveyConfiguration $answerScore)
    {
        $this->answerScore = $answerScore;

        return $this;
    }

    /**
     * Get the value of score
     * @return float
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
    public function setScore(float $score)
    {
        $this->score = $score;

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
     * Get the value of validators
     *
     * @return  ?SurveyConfiguration
     */
    public function getValidators()
    {
        return $this->validators;
    }

    /**
     * Set the value of validators
     *
     * @param  ?SurveyConfiguration  $validators
     *
     * @return  self
     */
    public function setValidators(?SurveyConfiguration $validators)
    {
        $this->validators = $validators;

        return $this;
    }
}
