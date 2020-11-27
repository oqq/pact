<?php

declare(strict_types=1);

namespace Oqq\PactTest\Util;

use Oqq\Pact\Exception\InvalidArgumentException;
use Oqq\Pact\Util\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Oqq\Pact\Util\Assert
 */
final class AssertTest extends TestCase
{
    public function testItThrowsProprietaryException(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Assert::true(false);
    }
}
