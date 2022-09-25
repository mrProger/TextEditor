<?php

namespace PHPRouter;

class Route {
    public string $uri;
    public string $method;
    public object $action;

    public function __construct(string $uri, string $method, object $action) {
        $this->uri = $uri;
        $this->method = $method;
        $this->action = $action;
    }
}