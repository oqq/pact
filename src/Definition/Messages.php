<?php

declare(strict_types=1);

namespace Oqq\Pact\Definition;

use Oqq\Pact\Util\Assert;

/**
 * @implements \IteratorAggregate<Message>
 */
final class Messages implements \IteratorAggregate
{
    /** @var list<Message> */
    private array $messages;

    public static function fromArray(array $payload): self
    {
        Assert::isList($payload);
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

    public function getIterator(): \Traversable
    {
        yield from $this->messages;
    }

    /**
     * @no-named-arguments
     */
    private function __construct(Message ...$messages)
    {
        $this->messages = $messages;
    }
}
