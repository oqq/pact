<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition;

use Oqq\Pact\Definition\ProviderResponse;
use Oqq\PactTest\ValueObjectPayloadAssertion;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Oqq\Pact\Definition\ProviderResponse
 */
final class ProviderResponseTest extends TestCase
{
    public function testItWillCreateFromPerfectPayload(): void
    {
        $providerResponse = ProviderResponse::fromArray([
            'status' =>  PayloadExample::status(),
            'headers' => PayloadExample::headers(),
            'body' => PayloadExample::body(),
        ]);

        $payload = $providerResponse->toArray();

        Assert::assertArrayHasKey('status', $payload);
        Assert::assertIsInt($payload['status']);

        Assert::assertArrayHasKey('headers', $payload);
        Assert::assertIsArray($payload['headers']);

        Assert::assertArrayHasKey('body', $payload);
        Assert::assertIsArray($payload['body']);
    }

    /**
     * @dataProvider invalidPayloadProvider
     */
    public function testItWillThrowWithInvalidPayload(\Exception $expectedException, array $payloadExample): void
    {
        $this->expectExceptionObject($expectedException);

        ProviderResponse::fromArray($payloadExample);
    }

    /**
     * @return iterable<array-key, array{0: \Exception, 1: array}>
     */
    public function invalidPayloadProvider(): iterable
    {
        $perfectValues = [
            'status' =>  PayloadExample::status(),
            'headers' => PayloadExample::headers(),
            'body' => PayloadExample::body(),
        ];

        yield from ValueObjectPayloadAssertion::integer($perfectValues, 'status');
        yield from ValueObjectPayloadAssertion::array($perfectValues, 'headers');
        yield from ValueObjectPayloadAssertion::array($perfectValues, 'body');
    }
}
