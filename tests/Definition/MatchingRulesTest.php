<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition;

use Oqq\Pact\Definition\MatchingRules;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Oqq\Pact\Definition\MatchingRules
 */
final class MatchingRulesTest extends TestCase
{
    public function testItWillCreateFromPerfectPayload(): void
    {
        $rules = MatchingRules::fromArray([
            'body' => PayloadExample::matchingRule(),
        ]);

        $payload = $rules->toArray();

        Assert::assertArrayHasKey('body', $payload);
        Assert::assertIsArray($payload['body']);
    }

    /**
     * @dataProvider invalidPayloadProvider
     */
    public function testItWillThrowWithInvalidPayload(\Exception $expectedException, array $payloadExample): void
    {
        $this->expectExceptionObject($expectedException);

        MatchingRules::fromArray($payloadExample);
    }

    /**
     * @return iterable<array-key, array{0: \Exception, 1: array}>
     */
    public function invalidPayloadProvider(): iterable
    {
        yield 'invalid type' => [
            new \InvalidArgumentException('Expected map - associative array'),
            [PayloadExample::matchingRule()],
        ];

        yield 'invalid type for terms value' => [
            new \InvalidArgumentException('Expected an array. Got: integer'),
            ['body' => 5],
        ];
    }
}
