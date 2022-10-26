<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition;

use Oqq\Pact\Definition\Message;
use Oqq\PactTest\ValueObjectPayloadAssertion;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Oqq\Pact\Definition\Message
 */
final class MessageTest extends TestCase
{
    public function testItWillCreateFromPerfectPayload(): void
    {
        $message = Message::fromArray([
            'description' => 'test',
            'provider_states' => PayloadExample::providerStates(),
            'body' => [
                'content' => [
                    'some' => 'value'
                ],
                'matching_rules' => [],
            ],
            'metadata' => [
                'content' => [
                    'some' => 'value'
                ],
                'matching_rules' => [],
            ],
        ]);

        Assert::assertSame('test', $message->description()->value());
        Assert::assertSame(['some' => 'value'], $message->body()->content());
        Assert::assertSame(['some' => 'value'], $message->metadata()->content());

        $payload = $message->toArray();
        Assert::assertArrayHasKey('description', $payload);
        Assert::assertArrayHasKey('provider_states', $payload);
        Assert::assertArrayHasKey('body', $payload);
        Assert::assertArrayHasKey('metadata', $payload);
    }

    /**
     * @dataProvider invalidPayloadProvider
     */
    public function testItWillThrowWithInvalidPayload(\Exception $expectedException, array $payloadExample): void
    {
        $this->expectExceptionObject($expectedException);

        Message::fromArray($payloadExample);
    }

    /**
     * @return iterable<array-key, array{0: \Exception, 1: array}>
     */
    public function invalidPayloadProvider(): iterable
    {
        $perfectValues = [
            'description' => PayloadExample::description(),
            'provider_states' => PayloadExample::providerStates(),
            'body' => [
                'content' => [
                    'some' => 'value'
                ],
                'matching_rules' => [],
            ],
            'metadata' => [
                'content' => [
                    'some' => 'value'
                ],
                'matching_rules' => [],
            ],
        ];

        yield from ValueObjectPayloadAssertion::string($perfectValues, 'description');
        yield from ValueObjectPayloadAssertion::array($perfectValues, 'provider_states');
        yield from ValueObjectPayloadAssertion::array($perfectValues, 'body');
        yield from ValueObjectPayloadAssertion::array($perfectValues, 'metadata');
    }
}
