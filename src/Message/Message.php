<?php

declare(strict_types=1);

namespace Oqq\Pact\Message;

use Oqq\Pact\Definition\Message as MessageDefinition;

final class Message
{
    private string $body;
    private array $headers;

    public static function fromMessageDefinition(MessageDefinition $messageDefinition): self
    {
        return new self(
            $messageDefinition->body()->content(),
            $messageDefinition->metadata()
        );
    }

    public function body(): string
    {
        return $this->body;
    }

    public function headers(): array
    {
        return $this->headers;
    }

    private function __construct(string $body, array $headers)
    {
        $this->body = $body;
        $this->headers = $headers;
    }
}
