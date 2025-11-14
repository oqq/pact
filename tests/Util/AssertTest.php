<?php

declare(strict_types=1);

namespace Oqq\PactTest\Util;

use Oqq\Pact\Exception\InvalidArgumentException;
use Oqq\Pact\Util\Assert;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Assert::class)]
final class AssertTest extends TestCase
{
    public function testItThrowsProprietaryException(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Assert::true(false);
    }
}
