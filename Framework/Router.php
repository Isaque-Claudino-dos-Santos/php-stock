<?php


namespace App\Framework;

class Router
{
    /**
     * @var Route[]
     */
    private array $routes = [];


    public function get(string $uri, \Closure|array $action): void
    {
        $route = new Route($uri, 'GET', $action);
        $this->routes[] = $route;
    }

    public function post(string $uri, \Closure|array $action): void
    {
        $route = new Route($uri, 'POST', $action);
        $this->routes[] = $route;
    }

    public function put(string $uri, array $action): void
    {
        $route = new Route($uri, 'PUT', $action);
        $this->routes[] = $route;
    }

    public function delete(string $uri, array $action): void
    {
        $route = new Route($uri, 'DELETE', $action);
        $this->routes[] = $route;
    }


    public function boot(): void
    {
        foreach ($this->routes as $route) {
            if (!$route->wasRequested()) continue;

            $route->callAction();
            break;
        }
    }
}