<?php

declare(strict_types=1);

namespace Oqq\Pact\Definition\Matcher;

use Oqq\Pact\Definition\Matcher;
use Oqq\Pact\Util\Assert;

final class Collection extends Matcher
{
    public const MATCH_TYPE = 'collection';
    private int $min;

    public static function fromArray(array $payload): self
    {
        Assert::keyExists($payload, 'type');
        Assert::same($payload['type'], self::MATCH_TYPE);

        Assert::keyExists($payload, 'min');
        Assert::integer($payload['min']);
        Assert::greaterThanEq($payload['min'], 1);

        return new self($payload['min']);
    }

    public function toArray(): array
    {
        return [
            'type' => self::MATCH_TYPE,
            'min' => $this->min,
        ];
    }

    public function type(): string
    {
        return self::MATCH_TYPE;
    }

    public function min(): int
    {
        return $this->min;
    }

    private function __construct(int $min)
    {
        $this->min = $min;
    }
}
