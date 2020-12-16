<?php

declare(strict_types=1);

namespace Oqq\Pact\PactBuilder\Pattern;

use Oqq\Pact\Definition\Matcher;
use Oqq\Pact\PactBuilder\Pattern;

final class Like implements Pattern
{
    /** @var null|scalar|array<null|scalar|array> */
    private $generate;

    /**
     * @param null|scalar|array<null|scalar|array> $generate
     */
    public static function generateFromValue($generate): self
    {
        return new self($generate);
    }

    /**
     * @return null|scalar|array<null|scalar|array>
     */
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
     * @param null|scalar|array<null|scalar|array> $generate
     */
    private function __construct($generate)
    {
        $this->generate = $generate;
    }
}
