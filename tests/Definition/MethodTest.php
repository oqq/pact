<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition;

use Oqq\Pact\Definition\Method;
use Oqq\Pact\Exception\InvalidArgumentException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(\Oqq\Pact\Definition\Method::class)]
final class MethodTest extends TestCase
{
    public function testItWillCreateFromPerfectValue(): void
    {
        $method = Method::fromString('GET');

        Assert::assertSame('GET', $method->value());
    }

    public function testItWillThrowWithEmptyValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected a non-empty value. Got: ""');

        Method::fromString('');
    }
}
