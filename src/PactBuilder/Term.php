<?php

declare(strict_types=1);

namespace Oqq\Pact\PactBuilder;

use Oqq\Pact\Util\Assert;

final class Term
{
    private string $generate;
    private string $pattern;

    public static function generateWithPattern(string $generate, string $pattern): self
    {
        Assert::regex($generate, $pattern);

        return new self($generate, $pattern);
    }

    public function generate(): string
    {
        return $this->generate;
    }

    public function pattern(): string
    {
        return $this->pattern;
    }

    private function __construct(string $generate, string $pattern)
    {
        $this->generate = $generate;
        $this->pattern = $pattern;
    }
}
