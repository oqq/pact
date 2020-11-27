<?php

declare(strict_types=1);

namespace Oqq\Pact\Definition\Matcher;

use Oqq\Pact\Definition\Matcher;
use Oqq\Pact\Util\Assert;

final class Type extends Matcher
{
    public const MATCH_TYPE = 'type';

    public static function fromArray(array $payload): self
    {
        Assert::keyExists($payload, 'type');
        Assert::same($payload['type'], self::MATCH_TYPE);

        return new self();
    }

    public function toArray(): array
    {
        return [
            'type' => self::MATCH_TYPE,
        ];
    }

    private function __construct()
    {
    }
}
