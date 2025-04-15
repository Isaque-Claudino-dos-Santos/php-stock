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
        $route = new Route($action, $uri, 'GET');
        $this->routes[] = $route;
    }

    public function post(string $uri, \Closure|array $action): void
    {
        $route = new Route($action, $uri, 'POST');
        $this->routes[] = $route;
    }

    public function put(string $uri, array $action): void
    {
        $route = new Route($action, $uri, 'PUT');
        $this->routes[] = $route;
    }

    public function delete(string $uri, array $action): void
    {
        $route = new Route($action, $uri, 'DELETE');
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