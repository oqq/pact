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
        Assert::keyExists($payload, 'type');
        Assert::same($payload['type'], self::MATCH_TYPE);

        Assert::keyExists($payload, 'value');
        Assert::string($payload['value']);

        return new self($payload['value']);
    }

    public function toArray(): array
    {
        return [
            'type' => self::MATCH_TYPE,
            'value' => $this->value,
        ];
    }

    private function __construct(string $value)
    {
        $this->value = $value;
    }
}
