<?php

namespace Ibexa\Contracts\Rest\Output;

class Visitor
{
    public function setHeader(string $name, string $value): void
    {
    }

    public function suppressHeader(string $name): void
    {
    }
}
