<?php

namespace App\Framework;

class Response
{
    public function __construct(
        public readonly int   $status = 200,
        public readonly mixed $content = null
    )
    {
    }

    public function send(): void
    {
        $content = $this->content;

        if (is_array($content)) {
            $content = json_encode($content);
            header("content-type: application/json; charset=utf-8");
        }

        $contentLength = strlen($content);

        header("content-length: $contentLength");

        http_response_code($contentLength <= 0 ? 204 : $this->status);

        echo $content;
    }
}