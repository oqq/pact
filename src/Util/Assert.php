<?php

declare(strict_types=1);

namespace Oqq\Pact\Util;

use Oqq\Pact\Exception\InvalidArgumentException;

final class Assert extends \Webmozart\Assert\Assert
{
    /**
     * @psalm-pure
     */
    protected static function reportInvalidArgument($message): void
    {
        throw new InvalidArgumentException($message);
    }
}
