<?php

declare(strict_types=1);

namespace Oqq\Pact\Definition\Matcher;

use Oqq\Pact\Definition\Matcher;
use Oqq\Pact\Util\Assert;

final class Regex extends Matcher
{
    public const MATCH_TYPE = 'regex';

    private string $regex;

    public static function fromArray(array $payload): self
    {
        Assert::keyExists($payload, 'type');
        Assert::same($payload['type'], self::MATCH_TYPE);

        Assert::keyExists($payload, 'regex');
        Assert::string($payload['regex']);

        return new self($payload['regex']);
    }

    public function toArray(): array
    {
        return [
            'type' => self::MATCH_TYPE,
            'regex' => $this->regex,
        ];
    }

    private function __construct(string $regex)
    {
        $this->regex = $regex;
    }
}
