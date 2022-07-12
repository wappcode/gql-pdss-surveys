<?php

namespace GPDSurvey\Entities;

use GPDCore\Entities\AbstractEntityModel;
use Doctrine\ORM\Mapping as ORM;
use GraphQL\Doctrine\Annotation as API;

/**
 * Doctrine Entity For SurveyPresentation
 * 
 * Guarda en formato JSON la configuración de la presentación para encuestas, secciones y preguntas opciones de preguntas, etc
 * 
 * @ORM\Entity()
 * @ORM\Table(name="survey_configuration", indexes={
 * @ORM\Index(name="user_created_idx",columns={"created"}),
 * @ORM\Index(name="user_updated_idx",columns={"updated"})
 * })
 * 
 */
class SurveyConfiguration  extends AbstractEntityModel
{
    const RELATIONS_MANY_TO_ONE = [];

    const SURVEY_CONFIGURATION_TYPE_VALIDATORS = 'VALIDATORS';
    const SURVEY_CONFIGURATION_TYPE_PRESENTATION = 'PRESENTATION';
    const SURVEY_CONFIGURATION_TYPE_CONDITION = 'CONDITION';
    const SURVEY_CONFIGURATION_TYPE_ANSWER_SCORE = 'ANSWER_SCORE';
    /**
     * @ORM\Column(type="string", name="value", nullable=false) 
     * @var string
     */
    private $value;
    /**
     * @ORM\Column(type="string", name="type", nullable=false) 
     * @var string
     */
    private $type;

    /**
     * Get the value of value
     *
     * @API\Field(type="string")
     * @return  string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of value
     *
     * @param  array  $value
     *
     * @return  self
     */
    public function setValue(array $value)
    {
        $this->value = $value;

        return $this;
    }

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
}
