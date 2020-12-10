<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition;

use Oqq\Pact\Definition\Header;
use Oqq\PactTest\ValueObjectPayloadAssertion;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Oqq\Pact\Definition\Header
 */
final class HeaderTest extends TestCase
{
    public function testItWillCreateFromPerfectPayload(): void
    {
        $header = Header::fromArray([
            'value' =>  'application/json;charset=UTF-8',
            'matching_rule' => PayloadExample::matchingRule(),
        ]);

        $payload = $header->toArray();

        Assert::assertArrayHasKey('value', $payload);
        Assert::assertSame('application/json;charset=UTF-8', $payload['value']);

        Assert::assertArrayHasKey('matching_rule', $payload);
        Assert::assertIsArray($payload['matching_rule']);
    }

    /**
     * @dataProvider invalidPayloadProvider
     */
    public function testItWillThrowWithInvalidPayload(\Exception $expectedException, array $payloadExample): void
    {
        $this->expectExceptionObject($expectedException);

        Header::fromArray($payloadExample);
    }

    /**
     * @return iterable<array-key, array{0: \Exception, 1: array}>
     */
    public function invalidPayloadProvider(): iterable
    {
        $perfectValues = [
            'value' =>  'application/json;charset=UTF-8',
            'matching_rule' => PayloadExample::matchingRule(),
        ];

        yield from ValueObjectPayloadAssertion::string($perfectValues, 'value');
        yield from ValueObjectPayloadAssertion::array($perfectValues, 'matching_rule');
    }
}
