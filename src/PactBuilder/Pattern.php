<?php

declare(strict_types=1);

namespace Oqq\Pact\PactBuilder;

use Oqq\Pact\Definition\Matcher;

interface Pattern
{
    /**
     * @return null|scalar|array<null|scalar|array|Pattern>|Pattern
     */
    public function generate();

    public function matcher(): Matcher;
}
