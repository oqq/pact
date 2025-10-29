<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition;

use Oqq\Pact\Definition\Headers;
use Oqq\PactTest\ValueObjectPayloadAssertion;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(\Oqq\Pact\Definition\Headers::class)]
final class HeadersTest extends TestCase
{
    public function testItWillCreateFromPerfectPayload(): void
    {
        $headers = Headers::fromArray([
            'Content-Type' => [
                'value' => 'application/json;charset=UTF-8',
                'matching_rule' => PayloadExample::matchingRule(),
            ],
        ]);

        $payload = $headers->toArray();

        Assert::assertArrayHasKey('Content-Type', $payload);
        Assert::assertIsArray($payload['Content-Type']);
    }

    #[DataProvider('invalidPayloadProvider')]
    public function testItWillThrowWithInvalidPayload(\Exception $expectedException, array $payloadExample): void
    {
        $this->expectExceptionObject($expectedException);

        Headers::fromArray($payloadExample);
    }

    /**
     * @return iterable<array-key, array{0: \Exception, 1: array}>
     */
    public static function invalidPayloadProvider(): iterable
    {
        yield 'invalid type' => [
            new \InvalidArgumentException('Expected map - associative array'),
            [
                [
                    'value' => 'application/json;charset=UTF-8',
                    'matching_rule' => PayloadExample::matchingRule(),
                ],
            ],
        ];

        yield 'invalid type for terms value' => [
            new \InvalidArgumentException('Expected an array. Got: string'),
            ['Content-Type' => 'application/json;charset=UTF-8'],
        ];
    }
}
