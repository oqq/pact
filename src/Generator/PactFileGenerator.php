<?php

declare(strict_types=1);

namespace Oqq\Pact\Generator;

use Oqq\Pact\Definition\Message;
use Oqq\Pact\Definition\MessagePact;
use Oqq\Pact\Definition\Messages;
use Oqq\Pact\Exception\RuntimeException;

final class PactFileGenerator
{
    public function generateMessagePact(Specification $specification, MessagePact $pact): array
    {
        if ($specification->version() !== '3.0.0') {
            throw new RuntimeException(
                \sprintf(
                    'Could not generate for version "%s"',
                    $specification->version(),
                )
            );
        }

        return [
            'consumer' => $pact->consumer()->toArray(),
            'provider' => $pact->provider()->toArray(),
            'messages' => $this->generateMessagesContent($pact->messages()),
            'metadata' => [
                'pactSpecification' => $specification->toArray(),
            ],
        ];
    }

    private function generateMessagesContent(Messages $messages): array
    {
        $result = [];

        /** @var Message $message */
        foreach ($messages as $message) {
            $result[] = [
                'description' => $message->description()->value(),
                'providerStates' => [],
                'contents' => $message->body()->content(),
                'metaData' => $message->metadata(),
                'matchingRules' => [
                    'body' => $message->body()->matchingRules()->toArray(),
                ],
            ];
        }

        return $result;
    }
}
