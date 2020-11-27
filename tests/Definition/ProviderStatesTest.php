<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition;

use Oqq\Pact\Definition\ProviderStates;
use Oqq\Pact\Exception\InvalidArgumentException;
use Oqq\PactTest\ValueObjectPayloadAssertion;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Oqq\Pact\Definition\ProviderStates
 */
final class ProviderStatesTest extends TestCase
{
    /**
     * @dataProvider validValueProvider
     */
    public function testItWillCreateFromPerfectPayload(array $payloadExample): void
    {
        $state = ProviderStates::fromArray($payloadExample);

        Assert::assertCount(\count($payloadExample), $state->toArray());
        Assert::assertContainsOnly('array', $state->toArray());
    }

    /**
     * @return iterable<array-key, array<array>>
     */
    public function validValueProvider(): iterable
    {
        yield 'empty list' => [
            [],
        ];

        yield 'one state' => [
            [
                PayloadExample::providerState(),
            ],
        ];

        yield 'two states' => [
            [
                PayloadExample::providerState(),
                PayloadExample::providerState(),
            ],
        ];
    }

    /**
     * @dataProvider invalidPayloadProvider
     */
    public function testItWillThrowWithInvalidPayload(\Exception $expectedException, array $payloadExample): void
    {
        $this->expectExceptionObject($expectedException);

        ProviderStates::fromArray($payloadExample);
    }

    /**
     * @return iterable<array-key, array{0: \Exception, 1: array}>
     */
    public function invalidPayloadProvider(): iterable
    {
        yield 'invalid type' => [
            new InvalidArgumentException('Expected an array. Got: integer'),
            [5],
        ];
    }
}
