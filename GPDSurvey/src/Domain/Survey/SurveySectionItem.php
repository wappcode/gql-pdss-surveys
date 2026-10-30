<?php

namespace GPDSurvey\Domain\Survey;

final class SurveySectionItem
{
    private string $id;
    private string $type;
    private int $order;
    private bool $hidden;

    public function __construct(string $id, string $type, int $order = 1, bool $hidden = false)
    {
        $this->id = $id;
        $this->type = $type;
        $this->order = $order;
        $this->hidden = $hidden;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function order(): int
    {
        return $this->order;
    }

    public function isHidden(): bool
    {
        return $this->hidden;
    }
}
