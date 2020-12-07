<?php

declare(strict_types=1);

namespace Oqq\Pact\Message;

interface MessageConsumer
{
    public function consume(Message $message): void;
}
