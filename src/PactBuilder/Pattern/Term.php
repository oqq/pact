<?php

declare(strict_types=1);

namespace Oqq\Pact\PactBuilder\Pattern;

use Oqq\Pact\Definition\Matcher;
use Oqq\Pact\PactBuilder\Pattern;
use Oqq\Pact\Util\Assert;

final class Term implements Pattern
{
    private string $generate;
    private string $pattern;

    public static function generateWithPattern(string $generate, string $pattern): self
    {
        Assert::regex($generate, '(' . $pattern . ')');

        return new self($generate, $pattern);
    }

    public function generate(): string
    {
        return $this->generate;
    }

    public function matcher(): Matcher
    {
        return Matcher\Regex::fromArray([
            'type' => Matcher\Regex::MATCH_TYPE,
            'pattern' => $this->pattern,
        ]);
    }

    private function __construct(string $generate, string $pattern)
    {
        $this->generate = $generate;
        $this->pattern = $pattern;
    }
}
