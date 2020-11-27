<?php

declare(strict_types=1);

namespace Oqq\Pact\Definition;

use Oqq\Pact\Util\Assert;

final class QueryParam
{
    /** @var list<string> */
    private array $values;
    private MatchingRule $matchingRule;

    public static function fromArray(array $payload): self
    {
        Assert::keyExists($payload, 'values');
        Assert::isNonEmptyList($payload['values']);
        Assert::allString($payload['values']);

        Assert::keyExists($payload, 'matching_rule');
        Assert::isArray($payload['matching_rule']);

        $matchingRule = MatchingRule::fromArray($payload['matching_rule']);

        return new self($payload['values'], $matchingRule);
    }

    public function toArray(): array
    {
        return [
            'values' => $this->values,
            'matching_rule' => $this->matchingRule->toArray(),
        ];
    }

    /**
     * @param list<string> $values
     */
    private function __construct(array $values, MatchingRule $matchingRule)
    {
        $this->values = $values;
        $this->matchingRule = $matchingRule;
    }
}
