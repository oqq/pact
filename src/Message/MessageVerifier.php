<?php

declare(strict_types=1);

namespace Oqq\Pact\Message;

use Oqq\Pact\Definition\Consumer;
use Oqq\Pact\Definition\Message as MessageDefinition;
use Oqq\Pact\Definition\MessagePact;
use Oqq\Pact\Definition\Provider;

final class MessageVerifier
{
    private MessagePublisher $messagePublisher;

    /** @var list<MessageDefinition> */
    private array $messages = [];

    public function __construct(MessagePublisher $messagePublisher)
    {
        $this->messagePublisher = $messagePublisher;
    }

    public function deleteAllMessages(): void
    {
        $this->messages = [];
    }

    public function registerMessage(MessageDefinition $messageDefinition): void
    {
        $message = Message::fromMessageDefinition($messageDefinition);

        $this->messagePublisher->publish($message);
        $this->messages[] = $messageDefinition;
    }

    public function createPact(Consumer $consumer, Provider $provider): MessagePact
    {
        return MessagePact::fromArray([
            'consumer' => $consumer->toArray(),
            'provider' => $provider->toArray(),
            'messages' => \array_map(
                static fn (MessageDefinition $message): array => $message->toArray(),
                $this->messages
            ),
        ]);
    }
}
