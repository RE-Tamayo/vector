<?php

namespace Retamayo\Vector;

use Retamayo\Vector\Classes\DefaultFileCreator;
use Retamayo\Vector\Classes\PathResolver;
use Retamayo\Vector\Classes\File;

class Vector {

    private static ?Vector $instance = null;
    private array $routes = [];
    private array $httpResponses = [];

    public static function getInstance() {
        if (null === self::$instance) {
            $instance = new self();
        }
        return $instance;
    }

    public function run(bool $secure = false, bool $csrfToken = false) {
        //Creates the routes file
        DefaultFileCreator::createRoute();
        //Creates the http responses
        DefaultFileCreator::createHttpResponses();
        //Add default http responses
        $this->addHttpResponse('404', PathResolver::getHttpResponseDirPath() . '/404.html');

        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        $this->handleRoute($method, $uri);
    }

    private function handleRoute(string $method, string $uri) {
        foreach ($this->routes[$method] as $route => $callback) {
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $route);
            $pattern = "#^" . $pattern . "$#";
            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                if (is_callable($callback)) {
                    call_user_func_array($callback, $matches);
                } else {
                    if (file_exists($callback)) {
                        include $callback;
                    }
                }
                return;
            }
        }
        include $this->httpResponses[404];
        http_response_code(404);
    }

    public function get(string $route, string|callable $path) {
        $this->routes['GET'][$route] = $path;
    }

    public function post(string $route, string|callable $path) {
        $this->routes['POST'][$route] = $path;
    }

    public function addHttpResponse(string $route, string|callable $path) {
        $this->httpResponses[$route] = $path;
    }
}