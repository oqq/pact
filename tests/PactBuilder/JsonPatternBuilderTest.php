<?php

declare(strict_types=1);

namespace Oqq\PactTest\PactBuilder;

use Oqq\Pact\PactBuilder\JsonPatternBuilder;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Oqq\Pact\PactBuilder\JsonPatternBuilder
 */
final class JsonPatternBuilderTest extends TestCase
{
    public function testItBuildsMessage(): void
    {
        $builder = new JsonPatternBuilder();
        $builder = $builder->withPattern([
            'only' => 'value',
            'some' => $builder->term('value', '/.*/'),
            'another' => [
                'deep' => $builder->term('value', '/.*/'),
            ],
            'array' => [
                $builder->term('value', '/.*/'),
            ],
        ]);

        $body = $builder->build();

        Assert::assertSame('{"only":"value","some":"value","another":{"deep":"value"},"array":["value"]}', $body->content());
        Assert::assertSame([
            '$.some' => [
                'combine' => 'AND',
                'matchers' => [
                    ['type' => 'regex', 'pattern' => '/.*/'],
                ],
            ],
            '$.another.deep' => [
                'combine' => 'AND',
                'matchers' => [
                    ['type' => 'regex', 'pattern' => '/.*/'],
                ],
            ],
            '$.array[0]' => [
                'combine' => 'AND',
                'matchers' => [
                    ['type' => 'regex', 'pattern' => '/.*/'],
                ],
            ],
        ], $body->matchingRules()->toArray());
    }

    public function testItIsImmutable(): void
    {
        $builder = new JsonPatternBuilder();

        Assert::assertNotSame($builder, $builder->withPattern([]));
    }
}
