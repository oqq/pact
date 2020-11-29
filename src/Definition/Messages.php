<?php

declare(strict_types=1);

namespace Oqq\Pact\Definition;

use Oqq\Pact\Util\Assert;

final class Messages
{
    /** @var list<Message> */
    private array $messages;

    public static function fromArray(array $payload): self
    {
        Assert::allIsArray($payload);

        $messages = \array_map(
            static fn (array $message): Message => Message::fromArray($message),
            $payload
        );

        return new self(...$messages);
    }

    public function toArray(): array
    {
        return \array_map(
            static fn (Message $message): array => $message->toArray(),
            $this->messages
        );
    }

    private function __construct(Message ...$messages)
    {
        $this->messages = $messages;
    }
}
