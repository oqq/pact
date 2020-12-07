<?php

declare(strict_types=1);

namespace Oqq\Pact\Message;

final class ConsumerMessagePublisher implements MessagePublisher
{
    private MessageConsumer $consumer;

    public function __construct(MessageConsumer $consumer)
    {
        $this->consumer = $consumer;
    }

    public function publish(Message $message): void
    {
        $this->consumer->consume($message);
    }
}
