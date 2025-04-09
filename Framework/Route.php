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
        $requestUri = $_SERVER['REQUEST_URI'];

        if (count(explode("/", $requestUri)) !== count(explode("/", $this->uri))) {
            return false;
        }

        return
            $_SERVER['REQUEST_METHOD'] === $this->method &&
            preg_match("/" . str_replace("/", "\/", preg_replace("/{\w*}/", "\w*", $this->uri)) . "/", $requestUri);
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