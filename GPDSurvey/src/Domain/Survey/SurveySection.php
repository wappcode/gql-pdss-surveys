<?php

namespace GPDSurvey\Domain\Survey;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

final class SurveySection
{
    private string $id;
    private string $title;
    private int $order;
    private bool $hidden;
    private Collection $items;

    public function __construct(string $id, string $title, int $order = 1, bool $hidden = false)
    {
        $this->id = $id;
        $this->title = $title;
        $this->order = $order;
        $this->hidden = $hidden;
        $this->items = new ArrayCollection();
    }

    public function id(): string
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function order(): int
    {
        return $this->order;
    }

    public function setOrder(int $order): void
    {
        $this->order = $order;
    }

    public function isHidden(): bool
    {
        return $this->hidden;
    }

    public function setHidden(bool $hidden): void
    {
        $this->hidden = $hidden;
    }

    public function items(): Collection
    {
        return $this->items;
    }

    public function addItem($item): void
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
        }
    }
}
