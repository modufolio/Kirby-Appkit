<?php

namespace App\Http;

use Closure;
use Kirby\Exception\InvalidArgumentException;
use Kirby\Http\Exceptions\NextRouteException;
use Kirby\Http\Route;

class Router extends \Kirby\Http\Router
{
    /**
     * Calls the Router by path and method.
     * This will try to find a Route object
     * and then call the Route action with
     * the appropriate arguments and a Result
     * object.
     */
    public function call(
        string|null $path = null,
        string $method = 'GET',
        Closure|null $callback = null
    ) {
        $path ??= '';
        $ignore = [];
        $result = null;
        $loop   = true;

        while ($loop === true) {
            $route = $this->find($path, $method, $ignore);

            if ($this->beforeEach instanceof Closure) {
                ($this->beforeEach)($route, $path, $method);
            }

            try {
                if ($callback) {
                    $result = $callback($route);
                } else {
                    $result = $this->callClosure($route);

                    if(is_array($result) === true ) {
                        $result = $this->callController($result, $route);
                    }

                }

                $loop = false;
            } catch (NextRouteException) {
                $ignore[] = $route;
            }

            if ($this->afterEach instanceof Closure) {
                $final  = $loop === false;
                $result = ($this->afterEach)($route, $path, $method, $result, $final);
            }
        }

        return $result;
    }

    public function callClosure($route)
    {
        return $route->action()->call($route, ...$route->arguments());
    }

    public function callController($result, $route)
    {
        [$controller, $controllerMethod] = $result;
        return call_user_func([new $controller(), $controllerMethod], ...$route->arguments());
    }
}