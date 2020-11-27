<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition;

use Oqq\Pact\Definition\Method;
use Oqq\Pact\Exception\InvalidArgumentException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Oqq\Pact\Definition\Method
 */
final class MethodTest extends TestCase
{
    public function testItWillCreateFromPerfectValue(): void
    {
        $status = Method::fromString('GET');

        Assert::assertSame('GET', $status->value());
    }

    public function testItWillThrowWithEmptyValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected a non-empty value. Got: ""');

        Method::fromString('');
    }
}
