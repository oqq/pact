<?php

declare(strict_types=1);

namespace Oqq\Pact\Definition;

use Oqq\Pact\Util\Assert;

final class Path
{
    private string $value;
    private MatchingRule $matchingRule;

    public static function fromArray(array $payload): self
    {
        Assert::keyExists($payload, 'value');
        Assert::stringNotEmpty($payload['value']);

        Assert::keyExists($payload, 'matching_rule');
        Assert::isArray($payload['matching_rule']);

        $matchingRule = MatchingRule::fromArray($payload['matching_rule']);

        return new self($payload['value'], $matchingRule);
    }

    public function toArray(): array
    {
        return [
            'value' => $this->value,
            'matching_rule' => $this->matchingRule->toArray(),
        ];
    }

    private function __construct(string $value, MatchingRule $matchingRule)
    {
        $this->value = $value;
        $this->matchingRule = $matchingRule;
    }
}
