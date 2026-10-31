<?php

namespace GPDSurvey\Domain\Entities;
// TODO: COnsiderar remover
trait ArraySerializable
{
    protected function serializeValue(mixed $value, array $seen = []): mixed
    {
        if ($value === null) {
            return null;
        }

        if (is_scalar($value)) {
            return $value;
        }

        if ($value instanceof \DateTimeInterface) {
            return $value->format(\DateTimeInterface::ATOM);
        }

        if ($value instanceof \GPDSurvey\Domain\ValueObject\ULID || $value instanceof \GPDSurvey\Domain\ValueObject\IntID) {
            return $value->value();
        }

        if ($value instanceof \GPDSurvey\Domain\ValueObject\SurveyConfigurationValue || $value instanceof \GPDSurvey\Domain\ValueObject\AnswerValue) {
            return $value->value();
        }

        if (is_array($value)) {
            $result = [];
            foreach ($value as $key => $item) {
                $result[$key] = $this->serializeValue($item, $seen);
            }
            return $result;
        }

        if (is_object($value)) {
            $objectId = spl_object_id($value);
            if (isset($seen[$objectId])) {
                return null;
            }
            $seen[$objectId] = true;

            if (method_exists($value, 'toArray')) {
                return $value->toArray();
            }

            if (method_exists($value, 'value')) {
                return $value->value();
            }

            return (string) $value;
        }

        return $value;
    }
}
