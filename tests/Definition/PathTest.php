<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition;

use Oqq\Pact\Definition\Path;
use Oqq\PactTest\ValueObjectPayloadAssertion;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Oqq\Pact\Definition\Path
 */
final class PathTest extends TestCase
{
    public function testItWillCreateFromPerfectPayload(): void
    {
        $path = Path::fromArray([
            'value' =>  '/',
            'matching_rule' => PayloadExample::matchingRule(),
        ]);

        $payload = $path->toArray();

        Assert::assertArrayHasKey('value', $payload);
        Assert::assertSame('/', $payload['value']);

        Assert::assertArrayHasKey('matching_rule', $payload);
        Assert::assertIsArray($payload['matching_rule']);
    }

    /**
     * @dataProvider invalidPayloadProvider
     */
    public function testItWillThrowWithInvalidPayload(\Exception $expectedException, array $payloadExample): void
    {
        $this->expectExceptionObject($expectedException);

        Path::fromArray($payloadExample);
    }

    /**
     * @return iterable<array-key, array{0: \Exception, 1: array}>
     */
    public function invalidPayloadProvider(): iterable
    {
        $perfectValues = [
            'value' =>  '/',
            'matching_rule' => PayloadExample::matchingRule(),
        ];

        yield from ValueObjectPayloadAssertion::string($perfectValues, 'value');
        yield from ValueObjectPayloadAssertion::array($perfectValues, 'matching_rule');
    }
}
