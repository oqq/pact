<?php

declare(strict_types=1);

namespace Oqq\Pact\Definition;

use Oqq\Pact\Util\Assert;

final class Query
{
    /** @var array<string, QueryParam> */
    private array $params;

    public static function fromArray(array $payload): self
    {
        Assert::isMap($payload);
        Assert::allIsArray($payload);

        $params = \array_map(
            static fn (array $param): QueryParam => QueryParam::fromArray($param),
            $payload
        );

        return new self($params);
    }

    public function toArray(): array
    {
        return \array_map(
            static fn (QueryParam $query): array => $query->toArray(),
            $this->params
        );
    }

    /**
     * @param array<string, QueryParam> $params
     */
    private function __construct(array $params)
    {
        $this->params = $params;
    }
}
