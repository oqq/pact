<?php

declare(strict_types=1);

namespace Oqq\PactTest\PactBuilder;

use Oqq\Pact\PactBuilder\JsonPatternBuilder;
use Oqq\Pact\PactBuilder\MessageBuilder;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Oqq\Pact\PactBuilder\MessageBuilder
 */
final class MessageBuilderTest extends TestCase
{
    public function testItBuildsMessage(): void
    {
        $message = ((new MessageBuilder())
            ->expectsToReceive('test description')
            ->given('something', ['important' => 'happen'])
            ->withMetadata(['some' => 'value'])
            ->withJsonBody(static fn (JsonPatternBuilder $body): JsonPatternBuilder => $body
                ->withPattern(['some' => 'value'])
            )
        )->build();

        Assert::assertSame('test description', $message->description()->value());
        Assert::assertSame([
            'some' => 'value',
            'Content-Type' => 'application/json',
        ], $message->metadata());
    }

    public function testItBuildsMessageWithEmptyBody(): void
    {
        $message = ((new MessageBuilder())
            ->expectsToReceive('test description')
        )->build();

        Assert::assertSame('', $message->body()->content());
    }

    public function testItIsImmutable(): void
    {
        $builder = new MessageBuilder();

        Assert::assertNotSame($builder, $builder->expectsToReceive('test description'));
        Assert::assertNotSame($builder, $builder->given('something', ['important' => 'happen']));
        Assert::assertNotSame($builder, $builder->withMetadata(['some' => 'value']));
        Assert::assertNotSame($builder, $builder->withJsonBody(static fn (JsonPatternBuilder $body): JsonPatternBuilder => $body));
    }
}
