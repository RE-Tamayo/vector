<?php

namespace Retamayo\Vector;

use Retamayo\Vector\Classes\PathResolver;
use Retamayo\Vector\Classes\File;

class Vector {

    private static ?Vector $instance = null;
    private array $routes = [];

    public static function getInstance() {
        if (null === self::$instance) {
            $instance = new self();
        }
        return $instance;
    }

    public function run(bool $secure = false, bool $csrfToken = false) {
        File::createPath(PathResolver::getRouteDirPath());
        File::createFile(PathResolver::getRouteFilePath());
        File::createPath(PathResolver::getConfigDirPath());
        File::createFile(PathResolver::getRouteConfigPath());
        File::writeFile(PathResolver::getRouteConfigPath(), $this->createDefaultRouteConfig());
        File::writeFile(PathResolver::getRouteFilePath(), $this->createDefaultRoutes());
        require_once PathResolver::getRouteConfigPath();
        require_once PathResolver::getRouteFilePath();

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
        include DEFAULT_404;
        http_response_code(404);
    }

    public function get(string $route, string|callable $path) {
        $this->routes['GET'][$route] = $path;
    }

    public function post(string $route, string|callable $path) {
        $this->routes['POST'][$route] = $path;
    }

    private function createDefaultRoutes() {
        $buffer = <<<EOF
        <?php

        //Static routes
        \$this->get("/", function () {
            echo "Hello World";
        });

        //Dynamic routes
        \$this->get("/profile/{name}", function (\$name) {
            echo "Hello \$name";
        });

        EOF;
        return $buffer;
    }

    private function createDefaultRouteConfig() {
        $buffer = <<<EOF
        <?php
        
        //Define Default 404 Route.
        define('DEFAULT_404', 'views/404.html');

        EOF;
        return $buffer;
    }
}