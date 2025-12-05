<?php

class Router
{
    private $routes = [];

    public function add($method, $path, $handler)
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path, // Regex pattern support
            'handler' => $handler
        ];
    }

    public function dispatch($uri, $method)
    {
        // Remove query string
        $uri = parse_url($uri, PHP_URL_PATH);
        if ($uri !== '/' && substr($uri, -1) === '/') {
            $uri = rtrim($uri, '/');
        }

        foreach ($this->routes as $route) {
            if ($route['method'] === $method) {
                // Convert route pattern to regex
                $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<\1>[^/]+)', $route['path']);
                $pattern = "#^" . $pattern . "$#";

                if (preg_match($pattern, $uri, $matches)) {
                    // Extract named parameters
                    $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                    list($controllerName, $action) = explode('@', $route['handler']);
                    $controllerFile = __DIR__ . '/../controllers/' . $controllerName . '.php';

                    if (file_exists($controllerFile)) {
                        require_once $controllerFile;
                        $controller = new $controllerName();
                        return call_user_func_array([$controller, $action], $params);
                    } else {
                        die("Controller $controllerName not found");
                    }
                }
            }
        }

        // 404
        http_response_code(404);
        require_once __DIR__ . '/../views/404.php';
    }
}
