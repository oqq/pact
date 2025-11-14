<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition;

use Oqq\Pact\Definition\MatchingRules;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(\Oqq\Pact\Definition\MatchingRules::class)]
final class MatchingRulesTest extends TestCase
{
    public function testItWillCreateFromPerfectPayload(): void
    {
        $rules = MatchingRules::fromArray([
            '$.some' => PayloadExample::matchingRule(),
        ]);

        $payload = $rules->toArray();

        Assert::assertArrayHasKey('$.some', $payload);
        Assert::assertIsArray($payload['$.some']);

        Assert::assertArrayHasKey('$.some', \iterator_to_array($rules));
    }

    #[DataProvider('invalidPayloadProvider')]
    public function testItWillThrowWithInvalidPayload(\Exception $expectedException, array $payloadExample): void
    {
        $this->expectExceptionObject($expectedException);

        MatchingRules::fromArray($payloadExample);
    }

    /**
     * @return iterable<array-key, array{0: \Exception, 1: array}>
     */
    public static function invalidPayloadProvider(): iterable
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
