<?php

namespace Ibexa\Core\MVC\Symfony\Routing;

class SimplifiedRequest
{
    public function __construct(
        ?string $scheme = null,
        ?string $host = null,
        int|string|null $port = null,
        ?string $pathinfo = null,
        ?array $queryParams = null,
        ?array $languages = null,
        ?array $headers = null
    ) {
    }
}
