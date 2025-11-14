<?php

declare(strict_types=1);

namespace Oqq\PactTest\Message;

use Oqq\Pact\Definition\Consumer;
use Oqq\Pact\Definition\Message as MessageDefinition;
use Oqq\Pact\Definition\Provider;
use Oqq\Pact\Message\MessagePublisher;
use Oqq\Pact\Message\MessageVerifier;
use Oqq\PactTest\Definition\PayloadExample;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

#[CoversClass(\Oqq\Pact\Message\MessageVerifier::class)]
final class MessageVerifierTest extends TestCase
{
    /** @var MessagePublisher&MockObject */
    private MessagePublisher $messagePublisher;
    private MessageVerifier $messageVerifier;

    public function setUp(): void
    {
        parent::setUp();

        $this->messagePublisher = $this->createMock(MessagePublisher::class);
        $this->messageVerifier = new MessageVerifier($this->messagePublisher);
    }

    public function testItThrowsIfMessageCouldNotBePublished(): void
    {
        $this->expectException(\RuntimeException::class);

        $message = MessageDefinition::fromArray(PayloadExample::message());

        $this->messagePublisher->expects(self::atLeastOnce())
            ->method('publish')
            ->willThrowException(new \RuntimeException());

        $this->messageVerifier->registerMessage($message);
    }

    public function testItRegistersMessages(): void
    {
        $message = MessageDefinition::fromArray(PayloadExample::message());
        $consumer = Consumer::fromArray(PayloadExample::consumer());
        $provider = Provider::fromArray(PayloadExample::provider());

        $this->messageVerifier->registerMessage($message);

        $pact = $this->messageVerifier->createPact($consumer, $provider);

        Assert::assertSame([
            'consumer' => PayloadExample::consumer(),
            'provider' => PayloadExample::provider(),
            'messages' => [
                PayloadExample::message(),
            ],
        ], $pact->toArray());
    }

    public function testItDeletesMessages(): void
    {
        $message = MessageDefinition::fromArray(PayloadExample::message());
        $consumer = Consumer::fromArray(PayloadExample::consumer());
        $provider = Provider::fromArray(PayloadExample::provider());

        $this->messageVerifier->registerMessage($message);
        $this->messageVerifier->deleteAllMessages();

        $pact = $this->messageVerifier->createPact($consumer, $provider);

        Assert::assertSame([
            'consumer' => PayloadExample::consumer(),
            'provider' => PayloadExample::provider(),
            'messages' => [],
        ], $pact->toArray());
    }
}
