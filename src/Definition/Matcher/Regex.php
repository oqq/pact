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
        Assert::keyExists($payload, 'match');
        Assert::same($payload['match'], self::MATCH_TYPE);

        Assert::keyExists($payload, 'pattern');
        Assert::string($payload['pattern']);

        return new self($payload['pattern']);
    }

    public function toArray(): array
    {
        return [
            'match' => self::MATCH_TYPE,
            'pattern' => $this->pattern,
        ];
    }

    public function match(): string
    {
        return self::MATCH_TYPE;
    }

    public function pattern(): string
    {
        return $this->pattern;
    }

    private function __construct(string $pattern)
    {
        $this->pattern = $pattern;
    }
}
