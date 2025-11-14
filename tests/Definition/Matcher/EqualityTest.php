<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition\Matcher;

use Oqq\Pact\Definition\Matcher\Equality;
use Oqq\Pact\Exception\InvalidArgumentException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(\Oqq\Pact\Definition\Matcher\Equality::class)]
final class EqualityTest extends TestCase
{
    public function testItWillCreateFromPerfectPayload(): void
    {
        $matcher = Equality::fromArray([
            'match' =>  'equality',
        ]);

        Assert::assertSame('equality', $matcher->match());

        $payload = $matcher->toArray();

        Assert::assertArrayHasKey('match', $payload);
        Assert::assertSame('equality', $payload['match']);
    }

    #[DataProvider('invalidPayloadProvider')]
    public function testItWillThrowWithInvalidPayload(\Exception $expectedException, array $payloadExample): void
    {
        $this->expectExceptionObject($expectedException);

        /** @psalm-suppress ArgumentTypeCoercion */
        Equality::fromArray($payloadExample);
    }

    /**
     * @return iterable<array-key, array{0: \Exception, 1: array}>
     */
    public static function invalidPayloadProvider(): iterable
    {
        yield 'missing type' => [
            new InvalidArgumentException('Expected the key "match" to exist.'),
            [],
        ];

        yield 'invalid type' => [
            new InvalidArgumentException('Expected a value identical to "equality". Got: "invalid"'),
            [
                'match' => 'invalid',
            ],
        ];
    }
}
