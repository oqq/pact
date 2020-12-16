<?php

declare(strict_types=1);

namespace Oqq\Pact\PactBuilder;

use Oqq\Pact\Definition\Matcher;

/**
 * @psalm-type JsonPatternType null|scalar|array|Pattern
 */
interface Pattern
{
    /**
     * @return JsonPatternType
     */
    public function generate();

    public function matcher(): Matcher;
}
