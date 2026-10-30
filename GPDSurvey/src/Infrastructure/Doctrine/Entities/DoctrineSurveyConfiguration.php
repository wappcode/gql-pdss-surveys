<?php

namespace GPDSurvey\Infrastructure\Doctrine\Entities;

use Doctrine\ORM\Mapping as ORM;
use PDSSUtilities\AbstractEntityModel;

#[ORM\Entity]
#[ORM\Table(
    name: 'gpd_survey_configuration',
    indexes: [
        new ORM\Index(name: 'user_created_idx', columns: ['created']),
        new ORM\Index(name: 'user_updated_idx', columns: ['updated']),
    ]
)]
class DoctrineSurveyConfiguration extends AbstractEntityModel
{


    #[ORM\Column(type: 'json', name: 'config_value', nullable: false)]
    private array $value;

    #[ORM\Column(type: 'string', name: 'config_type', nullable: false)]
    private string $type;

    #[ORM\Column(type: 'datetimetz_immutable', name: 'created', nullable: false)]
    protected \DateTimeImmutable $created;

    #[ORM\Column(type: 'datetimetz_immutable', name: 'updated', nullable: false)]
    protected \DateTimeImmutable $updated;

    public function getValue(): array
    {
        return $this->value;
    }

    public function setValue(array $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
