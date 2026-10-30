<?php

namespace GPDSurvey\Entities;

use GraphQL\Doctrine\Annotation as API;

class SurveyConfiguration
{
    protected $id;
    protected $created;
    protected $updated;

    const RELATIONS_MANY_TO_ONE = [];


    /**
     * @ORM\Column(type="json", name="config_value", nullable=false) 
     * @var array
     */
    private $value;
    /**
     * @ORM\Column(type="string", name="config_type", nullable=false) 
     * @var string
     */
    private $type;

    /**
     * Get the value of value
     *
     * @API\Field(type="GPDSurvey\Graphql\Types\TypeSurveyConfigurationValue")
     * @return  array
     */
    public function getValue(): array
    {
        return $this->value;
    }

    /**
     * Set the value of value
     *
     * @API\Input(type="GPDSurvey\Graphql\Types\TypeSurveyConfigurationValue")
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
     * @API\Field(type="GPDSurvey\Graphql\Types\TypeSurveyConfigurationType")
     * @return  string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @API\Input(type="GPDSurvey\Graphql\Types\TypeSurveyConfigurationType")
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
