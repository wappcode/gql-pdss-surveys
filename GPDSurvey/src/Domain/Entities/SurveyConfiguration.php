<?php

namespace GPDSurvey\Domain\Entities;

use GPDSurvey\Domain\ValueObject\IntID;
use GPDSurvey\Domain\ValueObject\SurveyConfigurationValue;

class SurveyConfiguration
{
    protected \DateTimeImmutable $created;
    protected \DateTimeImmutable $updated;


    public function __construct(
        private IntID $id,
        private SurveyConfigurationValue $value,
        private string $type,
    ) {
        $this->created = new \DateTimeImmutable();
        $this->updated = new \DateTimeImmutable();
    }

    public function id(): IntID
    {
        return $this->id;
    }

    public function value(): SurveyConfigurationValue
    {
        return $this->value;
    }

    public function type(): string
    {
        return $this->type;
    }
    public function created(): \DateTimeImmutable
    {
        return $this->created;
    }

    public function updated(): \DateTimeImmutable
    {
        return $this->updated;
    }

    private function touch(): self
    {
        $this->updated = new \DateTimeImmutable();

        return $this;
    }
}
