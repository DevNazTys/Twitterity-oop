<?php

class Router {
    private static $routes = [];
    private static $currentRoute = null;

    public static function get($uri, $controller, $action = 'index') {
        self::addRoute('GET', $uri, $controller, $action);
    }

    public static function post($uri, $controller, $action = 'index') {
        self::addRoute('POST', $uri, $controller, $action);
    }

    public static function any($uri, $controller, $action = 'index') {
        self::addRoute(['GET', 'POST'], $uri, $controller, $action);
    }

    private static function addRoute($methods, $uri, $controller, $action) {
        if (!is_array($methods)) {
            $methods = [$methods];
        }

        foreach ($methods as $method) {
            self::$routes[$method][$uri] = [
                'controller' => $controller,
                'action' => $action
            ];
        }
    }

    public static function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = self::getUri();

        // Check for exact match first
        if (isset(self::$routes[$method][$uri])) {
            self::$currentRoute = self::$routes[$method][$uri];
            return self::executeRoute(self::$routes[$method][$uri]);
        }

        // Check for parameterized routes
        foreach (self::$routes[$method] ?? [] as $routeUri => $route) {
            if (self::matchRoute($routeUri, $uri)) {
                self::$currentRoute = $route;
                return self::executeRoute($route);
            }
        }

        // Route not found
        self::handle404();
    }

    private static function getUri() {
        $uri = $_SERVER['REQUEST_URI'];
        
        // Remove query string
        if (strpos($uri, '?') !== false) {
            $uri = substr($uri, 0, strpos($uri, '?'));
        }

        // Remove trailing slash except for root
        if ($uri !== '/' && substr($uri, -1) === '/') {
            $uri = substr($uri, 0, -1);
        }

        return $uri;
    }

    private static function matchRoute($routeUri, $requestUri) {
        // Convert route pattern to regex
        $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $routeUri);
        $pattern = '#^' . $pattern . '$#';
        
        return preg_match($pattern, $requestUri);
    }

    private static function executeRoute($route) {
        $controllerName = $route['controller'];
        $actionName = $route['action'];

        // Include controller file if it's a file path
        if (strpos($controllerName, '.php') !== false) {
            include $controllerName;
            return;
        }

        // Handle class-based controllers
        if (class_exists($controllerName)) {
            $controller = new $controllerName();
            if (method_exists($controller, $actionName)) {
                return $controller->$actionName();
            }
        }

        // Handle static method calls
        if (strpos($controllerName, '::') !== false) {
            list($class, $method) = explode('::', $controllerName);
            if (class_exists($class) && method_exists($class, $method)) {
                return $class::$method();
            }
        }

        // Controller or action not found
        self::handle404();
    }

    private static function handle404() {
        header("HTTP/1.1 404 Not Found");
        echo "404 - Page Not Found";
        exit;
    }

    public static function redirect($uri, $statusCode = 302) {
        header("Location: $uri", true, $statusCode);
        exit;
    }

    public static function url($uri) {
        // Helper method to generate URLs
        return $uri;
    }

    public static function getCurrentRoute() {
        return self::$currentRoute;
    }
} 