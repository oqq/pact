<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition;

use Oqq\Pact\Definition\Description;
use Oqq\Pact\Exception\InvalidArgumentException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Oqq\Pact\Definition\Description
 */
final class DescriptionTest extends TestCase
{
    public function testItWillCreateFromPerfectValue(): void
    {
        $status = Description::fromString('test');

        Assert::assertSame('test', $status->value());
    }

    public function testItWillThrowWithEmptyValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected a non-empty value. Got: ""');

        Description::fromString('');
    }
}
