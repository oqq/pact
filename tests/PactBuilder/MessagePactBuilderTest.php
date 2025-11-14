<?php

declare(strict_types=1);

namespace Oqq\PactTest\PactBuilder;

use Oqq\Pact\PactBuilder\MessageBuilder;
use Oqq\Pact\PactBuilder\MessagePactBuilder;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(\Oqq\Pact\PactBuilder\MessagePactBuilder::class)]
final class MessagePactBuilderTest extends TestCase
{
    public function testItBuildsPact(): void
    {
        $pact = ((new MessagePactBuilder())
            ->consumer('test-consumer')
            ->hasPactWith('test-provider')
            ->withMessage(static fn (MessageBuilder $message): MessageBuilder => $message
                ->expectsToReceive('test description alpha')
            )
            ->withMessage(static fn (MessageBuilder $message): MessageBuilder => $message
                ->expectsToReceive('test description beta')
            )
        )->build();

        Assert::assertSame('test-consumer', $pact->consumer()->toArray()['name']);
        Assert::assertSame('test-provider', $pact->provider()->toArray()['name']);
        Assert::assertCount(2, $pact->messages()->toArray());
    }

    public function testItIsImmutable(): void
    {
        $builder = new MessagePactBuilder();

        Assert::assertNotSame($builder, $builder->consumer('test-consumer'));
        Assert::assertNotSame($builder, $builder->hasPactWith('test-provider'));
        Assert::assertNotSame($builder, $builder->withMessage(static fn (MessageBuilder $message): MessageBuilder => $message));
    }
}
