<?php

declare(strict_types=1);

namespace GPDSurvey\Infrastructure\Doctrine\Entities;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * 
 * @property-read string|null $id ULID identifier (26 characters)
 * @property-read DateTimeImmutable $created Creation timestamp
 * @property-read DateTimeImmutable $updated Last update timestamp
 */
#[ORM\MappedSuperclass]
abstract class DoctrineAbstractEntityModelUlid
{
    #[ORM\Id]
    #[ORM\Column(
        name: 'id',
        type: 'string',
        length: 26,
        options: ['fixed' => true]
    )]
    protected ?string $id = null;

    #[ORM\Column(name: 'created', type: 'datetimetz_immutable')]
    protected DateTimeImmutable $created;

    #[ORM\Column(name: 'updated', type: 'datetimetz_immutable')]
    protected DateTimeImmutable $updated;

    public function __construct()
    {
        $now = new DateTimeImmutable();
        $this->created = $now;
        $this->updated = $now;
    }
    public function getId(): ?string
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->id ?? 'new-entity';
    }

    /**
     * Get the value of created.
     */
    public function getCreated(): DateTimeImmutable
    {
        return $this->created;
    }

    public function setCreated(DateTimeImmutable $created): self
    {
        $this->created = $created;
        return $this;
    }

    /**
     * Get the value of updated.
     */
    public function getUpdated(): DateTimeImmutable
    {
        return $this->updated;
    }

    /**
     * Set the value of updated.
     * Useful for manual updates outside of lifecycle callbacks.
     */
    public function setUpdated(DateTimeImmutable $updated): self
    {
        $this->updated = $updated;
        return $this;
    }
}
