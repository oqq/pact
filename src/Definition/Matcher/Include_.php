<?php

declare(strict_types=1);

namespace Oqq\Pact\Definition\Matcher;

use Oqq\Pact\Definition\Matcher;
use Oqq\Pact\Util\Assert;

final class Include_ extends Matcher
{
    public const MATCH_TYPE = 'include';

    private string $include;

    public static function fromArray(array $payload): self
    {
        Assert::keyExists($payload, 'type');
        Assert::same($payload['type'], self::MATCH_TYPE);

        Assert::keyExists($payload, 'include');
        Assert::string($payload['include']);

        return new self($payload['include']);
    }

    public function toArray(): array
    {
        return [
            'type' => self::MATCH_TYPE,
            'include' => $this->include,
        ];
    }

    private function __construct(string $include)
    {
        $this->include = $include;
    }
}
