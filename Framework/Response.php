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

    public function sendHtml(string $path, array $data = []): void
    {
        $file = __ROOT__ . "/" . $path;

        if (!file_exists($file)) {
            return;
        }

        $contentLength = filesize($file);
        header("content-type: text/html; charset=utf-8");
        http_response_code($contentLength <= 0 ? 204 : $this->status);

        extract($data);
        require_once $file;
    }

    public function sendCSS(string $path): void
    {
        $file = __ROOT__ . "/" . $path;

        if (!file_exists($file)) {
            return;
        }

        $contentLength = filesize($file);
        header("content-type: text/css; charset=utf-8");
        http_response_code($contentLength <= 0 ? 204 : $this->status);


        echo file_get_contents($file);
    }

    public function sendJS(string $path): void
    {
        $file = __ROOT__ . "/" . $path;

        if (!file_exists($file)) {
            return;
        }

        $contentLength = filesize($file);
        header("content-type: text/javascript; charset=utf-8");
        http_response_code($contentLength <= 0 ? 204 : $this->status);


        echo file_get_contents($file);
    }
}