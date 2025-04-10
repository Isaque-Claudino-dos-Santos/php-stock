<?php

namespace App\Framework;

class Request
{
    public readonly array $params;
    public readonly array $query;
    public readonly array $body;


    public function __construct(private readonly Route $route)
    {
        $this->params = $this->getUriParamsFromRequest();
        $this->query = $this->getQueryFromRequest();
        $this->body = $this->getBodyFromRequest();
    }

    private function getBodyFromRequest(): array
    {
        return $_POST ?? [];
    }


    private function getQueryFromRequest(): array
    {
        return $_GET ?? [];
    }

    private function getUriParamsFromRequest(): array
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $uri = $this->route->uri;

        $params = [];
        $hasParams = preg_match_all("/{(\w*)}/", $uri);

        if (!$hasParams) {
            return [];
        }

        $explodedRequestUri = explode("/", $requestUri);
        $explodedUri = explode("/", $uri);

        $uriDiff = array_diff($explodedUri, $explodedRequestUri);

        foreach ($uriDiff as $uriDiffKey => $uriDiffValue) {
            $params[str_replace(["{", "}"], "", $uriDiffValue)] = $explodedRequestUri[$uriDiffKey];
        }

        return $params;
    }
}