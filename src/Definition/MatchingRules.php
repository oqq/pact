<?php

declare(strict_types=1);

namespace Oqq\Pact\Definition;

use Oqq\Pact\Util\Assert;

/**
 * @implements \IteratorAggregate<string, MatchingRule>
 */
final class MatchingRules implements \IteratorAggregate
{
    /** @var array<string, MatchingRule> */
    private array $matchingRules;

    public static function fromArray(array $payload): self
    {
        Assert::isMap($payload);
        Assert::allIsArray($payload);

        $matchingRules = \array_map(
            static fn (array $matchingRule): MatchingRule => MatchingRule::fromArray($matchingRule),
            $payload
        );

        return new self($matchingRules);
    }

    public function toArray(): array
    {
        return \array_map(
            static fn (MatchingRule $matchingRule): array => $matchingRule->toArray(),
            $this->matchingRules
        );
    }

    public function getIterator(): \Traversable
    {
        yield from $this->matchingRules;
    }

    /**
     * @param array<string, MatchingRule> $matchingRules
     */
    private function __construct(array $matchingRules)
    {
        $this->matchingRules = $matchingRules;
    }
}
