<?php

declare(strict_types=1);

namespace Oqq\Pact\Definition\Matcher;

use Oqq\Pact\Definition\Matcher;
use Oqq\Pact\Util\Assert;

final class Regex extends Matcher
{
    public const MATCH_TYPE = 'regex';

    private string $pattern;

    public static function fromArray(array $payload): self
    {
        Assert::keyExists($payload, 'type');
        Assert::same($payload['type'], self::MATCH_TYPE);

        Assert::keyExists($payload, 'pattern');
        Assert::string($payload['pattern']);

        return new self($payload['pattern']);
    }

    public function toArray(): array
    {
        return [
            'type' => self::MATCH_TYPE,
            'pattern' => $this->pattern,
        ];
    }

    private function __construct(string $pattern)
    {
        $this->pattern = $pattern;
    }
}
