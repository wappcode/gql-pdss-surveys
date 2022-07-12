<?php

namespace GPDSurvey\Entities;

use GPDCore\Entities\AbstractEntityModel;
use Doctrine\ORM\Mapping as ORM;

/**
 * Doctrine Entity For Survey
 * @ORM\Entity()
 * @ORM\Table(name="survey_content", indexes={
 * @ORM\Index(name="user_created_idx",columns={"created"}),
 * @ORM\Index(name="user_updated_idx",columns={"updated"})
 * })
 * 
 */
class SurveyContent  extends AbstractEntityModel
{
    const RELATIONS_MANY_TO_ONE = ['presentation'];
    const SURVEY_CONTENT_TYPE_HTML = 'HTML';
    const SURVEY_CONTENT_TYPE_VIDEO = 'VIDEO';
    const SURVEY_CONTENT_TYPE_IMAGE = 'IMAGE';
    const SURVEY_CONTENT_TYPE_DIVIDER = 'DIVIDER';

    /**
     * @ORM\Column(type="string", name="type", nullable=false) 
     * @var string
     */
    private $type;
    /**
     * @ORM\Column(type="text", name="body", nullable=true) 
     * @var string
     */
    private $body;
    /**
     * @ORM\OneToOne(targetEntity="\GPDSurvey\Entities\SurveyConfiguration")
     * @ORM\JoinColumn(name="presentation_id", referencedColumnName="id", nullable=true)
     * @var SurveyConfiguration
     */
    private $presentation;

    /**
     * Get the value of type
     *
     * @return  string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
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
     * Get the value of body
     *
     * @return  ?string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set the value of body
     *
     * @param  string  $body
     *
     * @return  self
     */
    public function setBody(?string $body)
    {
        $this->body = $body;

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
}
