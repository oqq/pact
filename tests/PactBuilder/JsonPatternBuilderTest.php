<?php

declare(strict_types=1);

namespace Oqq\PactTest\PactBuilder;

use Oqq\Pact\Definition\MatchingRules;
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
            'some' => 'value',
        ]);

        $body = $builder->build();

        Assert::assertSame(
            '{"some":"value"}',
            $body->content()
        );

        Assert::assertSame([], $body->matchingRules()->toArray());
    }

    public function testItIsImmutable(): void
    {
        $builder = new JsonPatternBuilder();

        Assert::assertNotSame($builder, $builder->withPattern([]));
    }

    public function testItGeneratesWithSimplePattern(): void
    {
        $builder = new JsonPatternBuilder();
        $builder = $builder->withPattern([
            'some' => [
                'deep' => 'value',
            ],
        ]);

        $body = $builder->build();

        Assert::assertSame(\json_encode([
            'some' => [
                'deep' => 'value',
            ],
        ], \JSON_THROW_ON_ERROR), $body->content());

        Assert::assertSame(MatchingRules::fromArray([
        ])->toArray(), $body->matchingRules()->toArray());
    }

    public function testItGeneratesWithTypePattern(): void
    {
        $builder = new JsonPatternBuilder();
        $builder = $builder->withPattern([
            'some' => $builder->like('value'),
        ]);

        $body = $builder->build();

        Assert::assertSame(\json_encode([
            'some' => 'value',
        ], \JSON_THROW_ON_ERROR), $body->content());

        Assert::assertSame(MatchingRules::fromArray([
            '$.some' => [
                'matchers' => [
                    ['match' => 'type'],
                ],
            ],
        ])->toArray(), $body->matchingRules()->toArray());
    }

    public function testItGeneratesWithExpressionPattern(): void
    {
        $builder = new JsonPatternBuilder();
        $builder = $builder->withPattern([
            'some' => $builder->term('value', '.*'),
        ]);

        $body = $builder->build();

        Assert::assertSame(\json_encode([
            'some' => 'value',
        ], \JSON_THROW_ON_ERROR), $body->content());

        Assert::assertSame(MatchingRules::fromArray([
            '$.some' => [
                'matchers' => [
                    ['match' => 'regex', 'pattern' => '.*'],
                ],
            ],
        ])->toArray(), $body->matchingRules()->toArray());
    }

    public function testItGeneratesWithArrayPattern(): void
    {
        $builder = new JsonPatternBuilder();
        $builder = $builder->withPattern([
            'each_like' => $builder->eachLike(
                $builder->like(1),
            ),
        ]);

        $body = $builder->build();

        Assert::assertSame(\json_encode([
            'each_like' => [1],
        ], \JSON_THROW_ON_ERROR), $body->content());

        Assert::assertSame(MatchingRules::fromArray([
            '$.each_like' => [
                'matchers' => [
                    ['match' => 'collection', 'min' => 1],
                ],
            ],
            '$.each_like[*]' => [
                'matchers' => [
                    ['match' => 'type'],
                ],
            ],
        ])->toArray(), $body->matchingRules()->toArray());
    }

    public function testItGeneratesWithObjectPattern(): void
    {
        $builder = new JsonPatternBuilder();
        $builder = $builder->withPattern([
            'each_like' => $builder->eachLike([
                'value' => $builder->like(1),
            ]),
        ]);

        $body = $builder->build();

        Assert::assertSame(\json_encode([
            'each_like' => [
                ['value' => 1],
            ],
        ], \JSON_THROW_ON_ERROR), $body->content());

        Assert::assertSame(MatchingRules::fromArray([
            '$.each_like' => [
                'matchers' => [
                    ['match' => 'collection', 'min' => 1],
                ],
            ],
            '$.each_like.*.value' => [
                'matchers' => [
                    ['match' => 'type'],
                ],
            ],
        ])->toArray(), $body->matchingRules()->toArray());
    }

    public function testItGeneratesWithPaths(): void
    {
        $builder = new JsonPatternBuilder();
        $builder = $builder->withPattern([
            'array' => [
                $builder->like(1),
                $builder->like(2),
            ],
            '.' => [
                '[' => $builder->like(1),
                ']' => $builder->like(1),
            ],
            'object' => [
                '(' => $builder->like(1),
                ')' => $builder->like(1),
            ],
            '"' => $builder->like(1),
            "'" => $builder->like(1),
        ]);

        $body = $builder->build();

        Assert::assertSame(\json_encode([
            'array' => [
                1,
                2
            ],
            '.' => [
                '[' => 1,
                ']' => 1,
            ],
            'object' => [
                '(' => 1,
                ')' => 1,
            ],
            '"' => 1,
            "'" => 1,
        ], \JSON_THROW_ON_ERROR), $body->content());

        Assert::assertSame(MatchingRules::fromArray([
            "$.array[0]" => [
                'matchers' => [
                    ['match' => 'type'],
                ],
            ],
            '$.array[1]' => [
                'matchers' => [
                    ['match' => 'type'],
                ],
            ],
            "$['.']['[']" => [
                'matchers' => [
                    ['match' => 'type'],
                ],
            ],
            "$['.'][']']" => [
                'matchers' => [
                    ['match' => 'type'],
                ],
            ],
            "$.object['(']" => [
                'matchers' => [
                    ['match' => 'type'],
                ],
            ],
            "$.object[')']" => [
                'matchers' => [
                    ['match' => 'type'],
                ],
            ],
            "$['\"']" => [
                'matchers' => [
                    ['match' => 'type'],
                ],
            ],
            "$['\'']" => [
                'matchers' => [
                    ['match' => 'type'],
                ],
            ],
        ])->toArray(), $body->matchingRules()->toArray());
    }
}
