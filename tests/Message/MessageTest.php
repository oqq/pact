<?php

declare(strict_types=1);

namespace Oqq\PactTest\Message;

use Oqq\Pact\Definition\Message as MessageDefinition;
use Oqq\Pact\Message\Message;
use Oqq\PactTest\Definition\PayloadExample;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Oqq\Pact\Message\Message
 */
final class MessageTest extends TestCase
{
    public function testItCreatesFromDefinition(): void
    {
        $messageDefinition = MessageDefinition::fromArray(\array_replace(PayloadExample::message(), [
            'body' => [
                'content' => [
                    'some' => 'value',
                ],
                'matching_rules' => [],
            ],
            'metadata' => [
                'content' => [
                    'metaAlpha' => 'data',
                ],
                'matching_rules' => [],
            ],
        ]));

        $message = Message::fromMessageDefinition($messageDefinition);

        Assert::assertSame(['some' => 'value'], $message->body());
        Assert::assertSame(['metaAlpha' => 'data'], $message->headers());
    }
}
