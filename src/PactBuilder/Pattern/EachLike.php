<?php

declare(strict_types=1);

namespace Oqq\Pact\PactBuilder\Pattern;

use Oqq\Pact\Definition\Matcher;
use Oqq\Pact\PactBuilder\Pattern;
use Oqq\Pact\Util\Assert;

final class EachLike implements Pattern
{
    /** @var null|scalar|array<null|scalar|array|Pattern>|Pattern */
    private $generate;
    private int $min;

    /**
     * @param null|scalar|array<null|scalar|array|Pattern>|Pattern $generate
     */
    public static function generateFromValue($generate, int $min): self
    {
        Assert::greaterThanEq($min, 1);

        return new self($generate, $min);
    }

    /**
     * @return null|scalar|array<null|scalar|array|Pattern>|Pattern
     */
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
     * @param null|scalar|array<null|scalar|array|Pattern>|Pattern $generate
     */
    private function __construct($generate, int $min)
    {
        $this->generate = $generate;
        $this->min = $min;
    }
}
