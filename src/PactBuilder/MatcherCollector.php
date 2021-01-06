<?php

declare(strict_types=1);

namespace Oqq\Pact\PactBuilder;

use Oqq\Pact\Definition\Matcher;

final class MatcherCollector
{
    /** @var array<string, array{matchers: array}> */
    private array $matcher = [];

    public function addMatcher(string $path, Matcher $matcher): void
    {
        $this->matcher[$path]['matchers'][] = $matcher->toArray();
    }

    public function generateMatchingRules(): array
    {
        return $this->matcher;
    }
}
