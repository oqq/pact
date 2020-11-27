<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition;

use Oqq\Pact\Definition\Body;
use Oqq\PactTest\ValueObjectPayloadAssertion;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Oqq\Pact\Definition\Body
 */
final class BodyTest extends TestCase
{
    public function testItWillCreateFromPerfectPayload(): void
    {
        $body = Body::fromArray([
            'content' =>  '{"some_json_value": true}',
            'matching_rules' => [
                '$.some_json_value' => PayloadExample::matchingRule(),
            ],
        ]);

        $payload = $body->toArray();

        Assert::assertArrayHasKey('content', $payload);
        Assert::assertSame('{"some_json_value": true}', $payload['content']);

        Assert::assertArrayHasKey('matching_rules', $payload);
        Assert::assertIsArray($payload['matching_rules']);
        Assert::assertArrayHasKey('$.some_json_value', $payload['matching_rules']);
    }

    /**
     * @dataProvider invalidPayloadProvider
     */
    public function testItWillThrowWithInvalidPayload(\Exception $expectedException, array $payloadExample): void
    {
        $this->expectExceptionObject($expectedException);

        Body::fromArray($payloadExample);
    }

    /**
     * @return iterable<array-key, array{0: \Exception, 1: array}>
     */
    public function invalidPayloadProvider(): iterable
    {
        $perfectValues = [
            'content' =>  '{"some_json_value": true}',
            'matching_rules' => [
                '$.some_json_value' => PayloadExample::matchingRule(),
            ],
        ];

        yield from ValueObjectPayloadAssertion::string($perfectValues, 'content');
        yield from ValueObjectPayloadAssertion::array($perfectValues, 'matching_rules');
    }
}
