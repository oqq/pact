<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition;

use Oqq\Pact\Definition\Query;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(\Oqq\Pact\Definition\Query::class)]
final class QueryTest extends TestCase
{
    public function testItWillCreateFromPerfectPayload(): void
    {
        $query = Query::fromArray([
            'terms' => PayloadExample::queryParam(),
        ]);

        $payload = $query->toArray();

        Assert::assertArrayHasKey('terms', $payload);
        Assert::assertIsArray($payload['terms']);
    }

    #[DataProvider('invalidPayloadProvider')]
    public function testItWillThrowWithInvalidPayload(\Exception $expectedException, array $payloadExample): void
    {
        $this->expectExceptionObject($expectedException);

        Query::fromArray($payloadExample);
    }

    /**
     * @return iterable<array-key, array{0: \Exception, 1: array}>
     */
    public static function invalidPayloadProvider(): iterable
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
