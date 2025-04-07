<?php

namespace App\Framework;

class Route
{
    public function __construct(
        public readonly string   $uri = "/",
        public readonly string   $method = "GET",
        public readonly \Closure $action,
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
        call_user_func_array($this->action, [new Request($this)]);
    }
}