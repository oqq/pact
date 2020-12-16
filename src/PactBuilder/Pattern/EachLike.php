<?php

declare(strict_types=1);

namespace Oqq\Pact\PactBuilder\Pattern;

use Oqq\Pact\Definition\Matcher;
use Oqq\Pact\PactBuilder\Pattern;
use Oqq\Pact\Util\Assert;

/**
 * @psalm-import-type JsonPatternType from Pattern
 */
final class EachLike implements Pattern
{
    /** @var JsonPatternType */
    private $generate;
    private int $min;

    /**
     * @param JsonPatternType $generate
     */
    public static function generateFromValue($generate, int $min): self
    {
        Assert::greaterThanEq($min, 1);

        return new self($generate, $min);
    }

    public function generate()
    {
        return $this->generate;
    }

    public function matcher(): Matcher
    {
        return Matcher\Collection::fromArray([
            'type' => Matcher\Collection::MATCH_TYPE,
            'min' => $this->min,
        ]);
    }

    /**
     * @param JsonPatternType $generate
     */
    private function __construct($generate, int $min)
    {
        $this->generate = $generate;
        $this->min = $min;
    }
}
