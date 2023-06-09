<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition;

use Oqq\Pact\Definition\Interactions;
use Oqq\Pact\Exception\InvalidArgumentException;
use Oqq\PactTest\ValueObjectPayloadAssertion;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Oqq\Pact\Definition\Interactions
 */
final class InteractionsTest extends TestCase
{
    public function testItWillCreateFromPerfectPayload(): void
    {
        $interactions = Interactions::fromArray([
            PayloadExample::interaction(),
            PayloadExample::interaction(),
        ]);

        Assert::assertContainsOnly('array', $interactions->toArray());
    }

    /**
     * @dataProvider invalidPayloadProvider
     */
    public function testItWillThrowWithInvalidPayload(\Exception $expectedException, array $payloadExample): void
    {
        $this->expectExceptionObject($expectedException);

        Interactions::fromArray($payloadExample);
    }

    /**
     * @return iterable<array-key, array{0: \Exception, 1: array}>
     */
    public function invalidPayloadProvider(): iterable
    {
        yield 'invalid type for interaction value' => [
            new InvalidArgumentException('Expected an array. Got: integer'),
            [5],
        ];
        yield 'invalid type array keys' => [
            new InvalidArgumentException('Expected list - non-associative array.'),
            ['x' => PayloadExample::interaction()],
        ];
    }
}
