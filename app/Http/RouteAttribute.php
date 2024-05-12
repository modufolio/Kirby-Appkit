<?php

namespace App\Http;

#[\Attribute(\Attribute::TARGET_METHOD)]
class RouteAttribute
{
    public function __construct(
        private string $pattern,
        private array $methods = ['GET'],
    ) {
    }

    public function getPattern(): string
    {
        return $this->pattern;
    }

    public function getMethods(): array
    {
        return $this->methods;
    }
}
