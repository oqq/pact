<?php

declare(strict_types=1);

namespace Oqq\Pact\Definition\Matcher;

use Oqq\Pact\Definition\Matcher;
use Oqq\Pact\Util\Assert;

final class Integer extends Matcher
{
    public const MATCH_TYPE = 'integer';

    public static function fromArray(array $payload): self
    {
        Assert::keyExists($payload, 'match');
        Assert::same($payload['match'], self::MATCH_TYPE);

        return new self();
    }

    public function toArray(): array
    {
        return [
            'match' => self::MATCH_TYPE,
        ];
    }

    public function match(): string
    {
        return self::MATCH_TYPE;
    }

    private function __construct()
    {
    }
}
