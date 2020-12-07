<?php

declare(strict_types=1);

namespace Oqq\Pact\Message;

interface MessagePublisher
{
    public function publish(Message $message): void;
}
