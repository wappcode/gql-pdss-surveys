<?php

namespace GPDSurvey\Domain\Survey;

final class SurveyId
{
    private const ALPHABET = '0123456789ABCDEFGHJKMNPQRSTVWXYZ';

    public function __construct(private string $value)
    {
        $value = trim($value);

        if ($value === '') {
            throw new \InvalidArgumentException('Survey id cannot be empty.');
        }

        if (!preg_match('/^[0-9A-HJKMNP-TV-Z]{26}$/', $value)) {
            throw new \InvalidArgumentException('Survey id must be a valid ULID.');
        }

        $this->value = $value;
    }

    public static function generate(): self
    {
        $timestamp = (int) floor(microtime(true) * 1000);
        $timePart = self::encodeBase32($timestamp, 10);
        $randomPart = self::encodeBase32(self::randomUint80(), 16);

        return new self($timePart . $randomPart);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    private static function randomUint80(): int
    {
        $bytes = random_bytes(10);
        $value = 0;

        foreach (str_split($bytes) as $byte) {
            $value = ($value << 8) | ord($byte);
        }

        return $value;
    }

    private static function encodeBase32(int $value, int $length): string
    {
        $result = '';

        for ($i = 0; $i < $length; $i++) {
            $digit = $value % 32;
            $result = self::ALPHABET[$digit] . $result;
            $value = intdiv($value, 32);
        }

        return $result;
    }
}
