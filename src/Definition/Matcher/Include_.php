<?php

declare(strict_types=1);

namespace Oqq\Pact\Definition\Matcher;

use Oqq\Pact\Definition\Matcher;
use Oqq\Pact\Util\Assert;

final class Include_ extends Matcher
{
    public const MATCH_TYPE = 'include';

    private string $value;

    public static function fromArray(array $payload): self
    {
        Assert::keyExists($payload, 'match');
        Assert::same($payload['match'], self::MATCH_TYPE);

        Assert::keyExists($payload, 'value');
        Assert::string($payload['value']);

        return new self($payload['value']);
    }

    public function toArray(): array
    {
        return [
            'match' => self::MATCH_TYPE,
            'value' => $this->value,
        ];
    }

    public function match(): string
    {
        return self::MATCH_TYPE;
    }

    public function value(): string
    {
        return $this->value;
    }

    private function __construct(string $value)
    {
        $this->value = $value;
    }
}
