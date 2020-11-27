<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition;

use Oqq\Pact\Definition\MatchingRule;
use Oqq\Pact\Exception\InvalidArgumentException;
use Oqq\PactTest\ValueObjectPayloadAssertion;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Oqq\Pact\Definition\MatchingRule
 */
final class MatchingRuleTest extends TestCase
{
    /**
     * @dataProvider validValueProvider
     */
    public function testItWillCreateFromPerfectPayload(array $payloadExample): void
    {
        $rule = MatchingRule::fromArray($payloadExample);

        $payload = $rule->toArray();

        Assert::assertArrayHasKey('combine', $payload);
        Assert::assertArrayHasKey('matchers', $payload);
        Assert::assertIsArray($payload['matchers']);
        Assert::assertContainsOnly('array', $payload['matchers']);
    }

    /**
     * @return iterable<array-key, array<array>>
     */
    public function validValueProvider(): iterable
    {
        yield 'full example' => [
            [
                'combine' => 'AND',
                'matchers' => [
                    ['type' => 'type'],
                    ['type' => 'decimal'],
                ],
            ],
        ];

        yield 'defaults' => [
            [
                'matchers' => [],
            ],
        ];
    }

    /**
     * @dataProvider invalidPayloadProvider
     */
    public function testItWillThrowWithInvalidPayload(\Exception $expectedException, array $payloadExample): void
    {
        $this->expectExceptionObject($expectedException);

        MatchingRule::fromArray($payloadExample);
    }

    /**
     * @return iterable<array-key, array{0: \Exception, 1: array}>
     */
    public function invalidPayloadProvider(): iterable
    {
        $perfectValues = [
            'combine' => 'AND',
            'matchers' => [],
        ];

        yield from ValueObjectPayloadAssertion::arrayList($perfectValues, 'matchers');
    }

    public function testItWillThrowWithInvalidCombineValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/Expected one of: [^\.]+\. Got: "invalid"/');

        MatchingRule::fromArray([
            'combine' => 'invalid',
            'matchers' => [],
        ]);
    }
}
