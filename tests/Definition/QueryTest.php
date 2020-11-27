<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition;

use Oqq\Pact\Definition\Query;
use Oqq\PactTest\ValueObjectPayloadAssertion;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Oqq\Pact\Definition\Query
 */
final class QueryTest extends TestCase
{
    public function testItWillCreateFromPerfectPayload(): void
    {
        $body = Query::fromArray([
            'terms' => PayloadExample::queryParam(),
        ]);

        $payload = $body->toArray();

        Assert::assertArrayHasKey('terms', $payload);
        Assert::assertIsArray($payload['terms']);
    }

    /**
     * @dataProvider invalidPayloadProvider
     */
    public function testItWillThrowWithInvalidPayload(\Exception $expectedException, array $payloadExample): void
    {
        $this->expectExceptionObject($expectedException);

        Query::fromArray($payloadExample);
    }

    /**
     * @return iterable<array-key, array{0: \Exception, 1: array}>
     */
    public function invalidPayloadProvider(): iterable
    {
        yield 'invalid type' => [
            new \InvalidArgumentException('Expected map - associative array'),
            [PayloadExample::queryParam()],
        ];

        yield 'invalid type for terms value' => [
            new \InvalidArgumentException('Expected an array. Got: integer'),
            ['terms' => 5],
        ];
    }
}
