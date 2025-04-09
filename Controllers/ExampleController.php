<?php

namespace App\Controllers;

class ExampleController
{
    public function index(): void
    {
        response(200, [
            "message" => "Hello, world!",
        ])->send();
    }
}