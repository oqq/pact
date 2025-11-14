<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition;

use Oqq\Pact\Definition\Description;
use Oqq\Pact\Exception\InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

#[CoversClass(Description::class)]
final class DescriptionTest extends TestCase
{
    public function testItWillCreateFromPerfectValue(): void
    {
        $description = Description::fromString('test');

        Assert::assertSame('test', $description->value());
    }

    public function testItWillThrowWithEmptyValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected a non-empty value. Got: ""');

        Description::fromString('');
    }
}
