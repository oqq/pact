<?php

declare(strict_types=1);

namespace Oqq\Pact\Definition;

use Oqq\Pact\Util\Assert;

final class Interactions
{
    /** @var list<Interaction> */
    private array $interactions;

    public static function fromArray(array $payload): self
    {
        Assert::isList($payload);
        Assert::allIsArray($payload);

        $interactions = \array_map(
            static fn (array $interaction): Interaction => Interaction::fromArray($interaction),
            $payload
        );

        return new self(...$interactions);
    }

    public function toArray(): array
    {
        return \array_map(
            static fn (Interaction $interaction): array => $interaction->toArray(),
            $this->interactions
        );
    }

    /**
     * @no-named-arguments
     */
    private function __construct(Interaction ...$interactions)
    {
        $this->interactions = $interactions;
    }
}
