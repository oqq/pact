<?php

declare(strict_types=1);

namespace Oqq\PactTest\Definition;

use Oqq\Pact\Definition\QueryParam;
use Oqq\PactTest\ValueObjectPayloadAssertion;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Oqq\Pact\Definition\QueryParam
 */
final class QueryParamTest extends TestCase
{
    public function testItWillCreateFromPerfectPayload(): void
    {
        $queryParam = QueryParam::fromArray([
            'values' =>  ['x', 'y'],
            'matching_rule' => PayloadExample::matchingRule(),
        ]);

        $payload = $queryParam->toArray();

        Assert::assertArrayHasKey('values', $payload);
        Assert::assertSame(['x', 'y'], $payload['values']);

        Assert::assertArrayHasKey('matching_rule', $payload);
        Assert::assertIsArray($payload['matching_rule']);
    }

    /**
     * @dataProvider invalidPayloadProvider
     */
    public function testItWillThrowWithInvalidPayload(\Exception $expectedException, array $payloadExample): void
    {
        $this->expectExceptionObject($expectedException);

        QueryParam::fromArray($payloadExample);
    }

    /**
     * @return iterable<array-key, array{0: \Exception, 1: array}>
     */
    public function invalidPayloadProvider(): iterable
    {
        $perfectValues = [
            'values' =>  ['x', 'y'],
            'matching_rule' => PayloadExample::matchingRule(),
        ];

        yield from ValueObjectPayloadAssertion::stringList($perfectValues, 'values');
        yield from ValueObjectPayloadAssertion::array($perfectValues, 'matching_rule');
    }
}
