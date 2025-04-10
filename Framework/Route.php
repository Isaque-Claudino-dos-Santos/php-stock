<?php

namespace App\Framework;

class Route
{
    public function __construct(
        public readonly string         $uri = "/",
        public readonly string         $method = "GET",
        public readonly \Closure|array $action,
    )
    {
    }

    public function wasRequested(): bool
    {
        $requestPath = $_SERVER['PATH_INFO'] ?? '//';

        $explodedRequestPath = explode("/", $requestPath);

        if ($explodedRequestPath[count($explodedRequestPath) - 1] === "") {
            unset($explodedRequestPath[count($explodedRequestPath) - 1]);
        }

        if (count($explodedRequestPath) !== count(explode("/", $this->uri))) {
            return false;
        }

        $requestMethod = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

        return
            $requestMethod === $this->method &&
            preg_match("/^" . str_replace("/", "\/", preg_replace("/{\w*}/", "\w*", $this->uri)) . "\/?$/", $requestPath);
    }

    public function callAction(): void
    {
        $action = $this->action;

        if (is_array($action)) {
            $action[0] = new $action[0];
        }

        call_user_func_array($action, [new Request($this)]);
    }
}