<?php

namespace GPDSurvey\Entities;

use Doctrine\ORM\Mapping as ORM;
use PDSSUtilities\AbstractEntityModel;


/**
 * Doctrine Entity For Survey
 */
#[ORM\Entity]
#[ORM\Table(name: 'gpd_survey_content', indexes: [
    new ORM\Index(name: 'user_created_idx', columns: ['created']),
    new ORM\Index(name: 'user_updated_idx', columns: ['updated']),
])]
class SurveyContent  extends AbstractEntityModel
{
    const RELATIONS_MANY_TO_ONE = ['presentation'];


    /**
     * @var string
     */
    #[ORM\Column(type: 'string', name: 'config_type', nullable: false)]
    private $type;
    /**
     * @var string
     */
    #[ORM\Column(type: 'text', name: 'body', nullable: true)]
    private $body;
    /**
     * @var SurveyConfiguration
     */
    #[ORM\ManyToOne(targetEntity: SurveyConfiguration::class)]
    #[ORM\JoinColumn(name: 'presentation_id', referencedColumnName: 'id', nullable: true)]
    private $presentation;

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
     * 
     * Combine ANY type with Presentation for custom
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
     * @param  ?SurveyConfiguration  $presentation
     *
     * @return  self
     */
    public function setPresentation(?SurveyConfiguration $presentation)
    {
        $this->presentation = $presentation;

        return $this;
    }
}
