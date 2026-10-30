<?php

namespace GPDSurvey\Domain\ValueObject;

class ULid
{
    private const ENCODING = '0123456789ABCDEFGHJKMNPQRSTVWXYZ';
    private string $value;

    public function __construct(?string $value = null)
    {
        if ($value === null) {
            $value = $this->generateValue();
        }
        if (count(str_split(trim($value))) !== 26) {
            throw new \InvalidArgumentException('ULid value must be 26 characters long.');
        }
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    protected function generateValue(): string
    {
        // ULID: 26 characters (Crockford's Base32)
        // Structure: 10 chars timestamp + 16 chars randomness

        $timestamp = (int)(microtime(true) * 1000);
        $randomBytes = random_bytes(10);

        // Pre-allocate result for better performance
        $result = str_repeat(' ', 26);

        // Encode timestamp (10 characters) - optimized with bitwise operations
        $t = $timestamp;
        for ($i = 9; $i >= 0; $i--) {
            $result[$i] = self::ENCODING[$t & 31];
            $t >>= 5;
        }

        // Encode random part (16 characters) - process 5 bits at a time
        // Convert 10 bytes (80 bits) to 16 base32 chars (16 * 5 = 80 bits)
        $bits = 0;
        $bitsCount = 0;
        $pos = 10;

        for ($i = 0; $i < 10; $i++) {
            $bits = ($bits << 8) | ord($randomBytes[$i]);
            $bitsCount += 8;

            while ($bitsCount >= 5) {
                $bitsCount -= 5;
                $result[$pos++] = self::ENCODING[($bits >> $bitsCount) & 31];
            }
        }

        return $result;
    }
}
