<?php

declare(strict_types=1);

namespace Oqq\Pact\Message;

use Oqq\Pact\Definition\Message as MessageDefinition;

final class Message
{
    private array $body;
    private array $headers;

    public static function fromMessageDefinition(MessageDefinition $messageDefinition): self
    {
        return new self($messageDefinition->body()->content(), $messageDefinition->metadata()->content());
    }

    public function body(): array
    {
        return $this->body;
    }

    public function headers(): array
    {
        return $this->headers;
    }

    private function __construct(array $body, array $headers)
    {
        $this->body = $body;
        $this->headers = $headers;
    }
}
