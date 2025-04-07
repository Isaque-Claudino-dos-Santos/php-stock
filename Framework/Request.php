<?php

namespace App\Framework;

class Request
{
    public readonly array $params;


    public function __construct(private readonly Route $route)
    {
        $this->params = $this->getUriParamsFromRequest();
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