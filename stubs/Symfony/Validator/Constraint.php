<?php

namespace Symfony\Component\Validator;

abstract class Constraint
{
    public function __construct(mixed $options = null, ?array $groups = null, mixed $payload = null)
    {
    }
}
