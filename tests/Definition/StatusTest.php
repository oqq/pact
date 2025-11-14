<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition;

use Oqq\Pact\Definition\Status;
use Oqq\Pact\Exception\InvalidArgumentException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(\Oqq\Pact\Definition\Status::class)]
final class StatusTest extends TestCase
{
    #[DataProvider('validValueProvider')]
    public function testItWillCreateFromPerfectValue(int $valueExample): void
    {
        $status = Status::fromInteger($valueExample);

        Assert::assertSame($valueExample, $status->value());
    }

    /**
     * @return iterable<array-key, array<int>>
     */
    public static function validValueProvider(): iterable
    {
        yield [100];
        yield [200];
        yield [599];
    }

    #[DataProvider('invalidValueProvider')]
    public function testItWillThrowWithInvalidValue(string $expectedMessage, int $valueExample): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches($expectedMessage);

        Status::fromInteger($valueExample);
    }

    /**
     * @return iterable<array-key, array{0: string, 1: int}>
     */
    public static function invalidValueProvider(): iterable
    {
        yield 'value to small' => [
            '/Expected a value between \d+ and \d+\. Got: 99/',
            99,
        ];

        yield 'value to large' => [
            '/Expected a value between \d+ and \d+\. Got: 600/',
            600,
        ];
    }
}
