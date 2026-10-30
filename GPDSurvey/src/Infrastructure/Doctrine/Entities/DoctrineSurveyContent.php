<?php

namespace GPDSurvey\Infrastructure\Doctrine\Entities;

use Doctrine\ORM\Mapping as ORM;
use PDSSUtilities\AbstractEntityModel;

#[ORM\Entity]
#[ORM\Table(
    name: 'gpd_survey_content',
    indexes: [
        new ORM\Index(name: 'user_created_idx', columns: ['created']),
        new ORM\Index(name: 'user_updated_idx', columns: ['updated']),
    ]
)]
class DoctrineSurveyContent extends AbstractEntityModel
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column(type: 'integer', name: 'id', nullable: false)]
    protected int $id;

    #[ORM\Column(type: 'string', name: 'config_type', nullable: false)]
    private string $type;

    #[ORM\Column(type: 'text', name: 'body', nullable: true)]
    private ?string $body;

    #[ORM\ManyToOne(targetEntity: DoctrineSurveyConfiguration::class)]
    #[ORM\JoinColumn(name: 'presentation_id', referencedColumnName: 'id', nullable: true)]
    private ?DoctrineSurveyConfiguration $presentation;

    #[ORM\Column(type: 'datetimetz_immutable', name: 'created', nullable: false)]
    protected \DateTimeImmutable $created;

    #[ORM\Column(type: 'datetimetz_immutable', name: 'updated', nullable: false)]
    protected \DateTimeImmutable $updated;
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
}
