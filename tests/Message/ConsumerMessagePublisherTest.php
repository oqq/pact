<?php

declare(strict_types=1);

namespace Oqq\PactTest\Message;

use Oqq\Pact\Definition\Message as MessageDefinition;
use Oqq\Pact\Message\ConsumerMessagePublisher;
use Oqq\Pact\Message\Message;
use Oqq\Pact\Message\MessageConsumer;
use Oqq\PactTest\Definition\PayloadExample;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Oqq\Pact\Message\ConsumerMessagePublisher
 */
final class ConsumerMessagePublisherTest extends TestCase
{
    /** @var MessageConsumer&MockObject  */
    private MessageConsumer $consumer;
    private ConsumerMessagePublisher $publisher;

    protected function setUp(): void
    {
        parent::setUp();

        $this->consumer = $this->createMock(MessageConsumer::class);
        $this->publisher = new ConsumerMessagePublisher($this->consumer);
    }

    public function testItPublishesMessage(): void
    {
        $messageDefinition = MessageDefinition::fromArray(PayloadExample::message());
        $message = Message::fromMessageDefinition($messageDefinition);

        $this->consumer->expects(self::once())
            ->method('consume')
            ->with(self::equalTo($message));

        $this->publisher->publish($message);
    }
}
