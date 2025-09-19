<?php
class PathRouter {
    private $routes = [];
    private $prefixDiscriminator;

    public function __construct($prefixDiscriminator) {
        $this->prefixDiscriminator = $prefixDiscriminator;
    }

    public function get($path, $handler) {
        $this->routes['GET'][$path] = $handler;
    }

    public function post($path, $handler) {
        $this->routes['POST'][$path] = $handler;
    }

    public function put($path, $handler) {
        $this->routes['PUT'][$path] = $handler;
    }

    public function delete($path, $handler) {
        $this->routes['DELETE'][$path] = $handler;
    }

    public function group($prefix, $callback) {
        $originalRoutes = $this->routes;
        $this->routes = [];
        
        // Execute callback to register group routes
        $callback($this);
        
        // Add prefix to all routes in the group
        foreach ($this->routes as $method => $routes) {
            foreach ($routes as $path => $handler) {
                $prefixedPath = trim($prefix, '/') . '/' . trim($path, '/');
                $originalRoutes[$method][$prefixedPath] = $handler;
            }
        }
        
        $this->routes = $originalRoutes;
    }

    public function resource($resource, $controller) {
        $this->get($resource, [$controller, 'index']);
        $this->get($resource . '/(\d+)', [$controller, 'show']);
        $this->post($resource, [$controller, 'store']);
        $this->put($resource . '/(\d+)', [$controller, 'update']);
        $this->delete($resource . '/(\d+)', [$controller, 'destroy']);
    }

    public function run() {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = $this->getPath();

        // Find exact path first
        if (isset($this->routes[$method][$path])) {
            $this->executeRoute($this->routes[$method][$path]);
            return;
        }

        // Search for routes with patterns (regex)
        foreach ($this->routes[$method] ?? [] as $pattern => $route) {
            if (preg_match('#^' . $pattern . '$#', $path, $matches)) {
                array_shift($matches); // Remove the entire match
                $this->executeRoute($route, $matches);
                return;
            }
        }

        // Route not found
        ResponseHelper::notFound('Endpoint not found');
    }

    private function getPath() {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Remove any API prefixes (including /ASGT/api/, /asgt/api/, /api/)
        $path = preg_replace($this->prefixDiscriminator, '', $path);
        
        return trim($path, '/');
    }

    private function executeRoute($route, $params = []) {
        if (is_array($route) && count($route) === 2) {
            // Call class method: [$controller, 'method']
            [$controller, $method] = $route;
            call_user_func_array([$controller, $method], $params);
        } elseif (is_callable($route)) {
            // Anonymous function
            call_user_func_array($route, $params);
        } else {
            ResponseHelper::error('Invalid route handler', 500);
        }
    }
}
