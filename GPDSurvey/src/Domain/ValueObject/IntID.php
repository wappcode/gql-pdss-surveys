<?php

namespace GPDSurvey\Domain\ValueObject;

class IntID
{
    private int $value;

    public function __construct(int $value = 0)
    {
        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }
}
