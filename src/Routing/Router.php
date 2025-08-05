<?php

namespace MiniCMS\Routing;

class Router {
    //table of registred roads - protected
    protected $routes = [];
    protected $path;

    function __construct(string $path) {
        $this->path = $path;
    }

    //register a GET path
    function get(string $path, callable $callback) {
        $this->routes['GET'][$path] = $callback;
    }

    //register a POST path
    function post(string $path, callable $callback) {
        $this->routes['POST'][$path] = $callback;
    }

    //register a DELETE path
    public function delete(string $path, callable $callback)
    {
        $this->routes['DELETE'][$path] = $callback;
    }

    //register a PUT path
    public function put(string $path, callable $callback)
    {
        $this->routes['PUT'][$path] = $callback;
    }

    //register a group
    public function group(string $prefix, callable $callback) 
    {
        $originalRoutes  = $this->routes;
        $this->routes = [];
        $callback($this);

        foreach ($this->routes as $method => $routes) {
            foreach ($routes as $path => $handler) {
                $combinedPath = rtrim($prefix, '/') . '/' . ltrim($path, '/');
                $originalRoutes[$method][$combinedPath] = $handler;
            }
        }

        $this->routes = $originalRoutes;
    }

    function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (!isset($this->routes[$method])) {
            http_response_code(404);
            require __DIR__ . '/../../public/views/404.php';
            return;
        }

        foreach ($this->routes[$method] as $route => $callback) {
           
            $pattern = preg_replace('#\{[\w]+\}#', '([\w-]+)', $route);
            $pattern = "#^" . $pattern . "$#";

            if (preg_match($pattern, $requestPath, $matches)) {
                array_shift($matches); 
                call_user_func_array($callback, $matches);
                return;
            }
        }

        http_response_code(404);
        require __DIR__ . '/../../public/views/404.php';
    }

}