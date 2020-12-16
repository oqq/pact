<?php

declare(strict_types=1);

namespace Oqq\Pact\PactBuilder\Pattern;

use Oqq\Pact\Definition\Matcher;
use Oqq\Pact\PactBuilder\Pattern;

/**
 * @psalm-import-type JsonPatternType from Pattern
 */
final class Like implements Pattern
{
    /** @var JsonPatternType */
    private $generate;

    /**
     * @param JsonPatternType $generate
     */
    public static function generateFromValue($generate): self
    {
        return new self($generate);
    }

    public function generate()
    {
        return $this->generate;
    }

    public function matcher(): Matcher
    {
        return Matcher\Type::fromArray([
            'type' => Matcher\Type::MATCH_TYPE,
        ]);
    }

    /**
     * @param JsonPatternType $generate
     */
    private function __construct($generate)
    {
        $this->generate = $generate;
    }
}
