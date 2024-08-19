<?php

class Router
{
    private $routes = [];

    public function get($path, $callback)
    {
        $this->addRoute('GET', $path, $callback);
    }

    public function post($path, $callback)
    {
        $this->addRoute('POST', $path, $callback);
    }

    public function put($path, $callback)
    {
        $this->addRoute('PUT', $path, $callback);
    }

    public function delete($path, $callback)
    {
        $this->addRoute('DELETE', $path, $callback);
    }

    private function addRoute($method, $path, $callback)
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $this->normalizePath($path),
            'callback' => $callback
        ];
    }

    private function normalizePath($path)
    {
        return rtrim($path, '/');
    }

    public function resolve()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = $this->normalizePath(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    
        // Debugging output
        error_log("Method: $method");
        error_log("Path: $path");
    
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $this->matchPath($route['path'], $path)) {
                $params = $this->extractParams($route['path'], $path);
                
                // Debugging output
                error_log("Matched Route: " . $route['path']);
                error_log("Params: " . implode(', ', $params));
                
                call_user_func_array($route['callback'], $params);
                return;
            }
        }
    
        // If no route matched, return a 404 response
        http_response_code(404);
        echo json_encode(['message' => 'Route not found']);
    }

    private function matchPath($routePath, $requestPath)
    {
        // Replace route parameters with regex to match the path
        $routePath = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', $routePath);
        return preg_match('#^' . $routePath . '$#', $requestPath);
    }

    private function extractParams($routePath, $requestPath)
    {
        $routeParts = explode('/', $routePath);
        $requestParts = explode('/', $requestPath);
        $params = [];

        foreach ($routeParts as $key => $part) {
            if (preg_match('/\{[a-zA-Z0-9_]+\}/', $part)) {
                $params[] = $requestParts[$key];
            }
        }

        return $params;
    }
}
