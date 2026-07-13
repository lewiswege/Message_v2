<?php

namespace App\Messaging\DTOs;

class ValidationResult
{
    public function __construct(
        public readonly bool $valid,
        public readonly array $errors = [],
    ) {}

    public static function success(): self
    {
        return new self(true);
    }

    public static function failure(array $errors): self
    {
        return new self(false, $errors);
    }
}
