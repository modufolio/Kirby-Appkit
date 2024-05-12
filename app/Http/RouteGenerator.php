<?php

namespace App\Http;


class RouteGenerator
{
    private array $controllers;

    public function __construct(array $controllers)
    {
        $this->controllers = $controllers;
    }

    public function getRoutes(): array
    {
        return iterator_to_array($this->generator());
    }

    /**
     * @throws \ReflectionException
     */
    public function generator(): \Generator
    {
        foreach ($this->controllers as $controller) {
            $reflectionController = new \ReflectionClass($controller);

            foreach ($reflectionController->getMethods() as $reflectionMethod) {
                $routeAttributes = $reflectionMethod->getAttributes(RouteAttribute::class);

                foreach ($routeAttributes as $routeAttribute) {
                    $route = $routeAttribute->newInstance();

                    yield [
                        'pattern' => $route->getPattern(),
                        'method' => implode( '|', $route->getMethods()),
                        'action' => fn() => [$controller, $reflectionMethod->getName()]
                    ];
                }
            }
        }
    }
}
