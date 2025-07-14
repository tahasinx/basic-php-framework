<?php
// Router class: Handles route registration, dispatching, and middleware
class Router
{
    // Registered routes
    private $routes = [];
    // Global middleware
    private $middleware = [];
    // Named routes for URL generation
    private $namedRoutes = [];

    // Register a GET route
    public function get($uri, $action, $middleware = [], $name = null)
    {
        $this->addRoute('GET', $uri, $action, $middleware, $name);
    }

    // Register a POST route
    public function post($uri, $action, $middleware = [], $name = null)
    {
        $this->addRoute('POST', $uri, $action, $middleware, $name);
    }

    // Add a route to the internal list
    private function addRoute($method, $uri, $action, $middleware = [], $name = null)
    {
        $route = [
            'method' => $method,
            'uri' => trim($uri, '/'),
            'action' => $action,
            'middleware' => $middleware,
            'name' => $name
        ];
        $this->routes[] = $route;
        if ($name) {
            $this->namedRoutes[$name] = $route['uri'];
        }
    }

    // Register a global middleware
    public function middleware($middleware)
    {
        $this->middleware[] = $middleware;
    }

    // Dispatch the request to the appropriate route and run middleware
    public function dispatch($method, $uri)
    {
        $uri = trim(parse_url($uri, PHP_URL_PATH), '/');

        // Run global middleware
        foreach ($this->middleware as $middleware) {
            $result = call_user_func($middleware);
            if ($result === false) {
                // Stop further processing if middleware returns false
                return;
            }
        }

        // Iterate through registered routes
        foreach ($this->routes as $route) {
            if ($method !== $route['method']) continue;

            // Match exact URI
            if ($route['uri'] === $uri) {
                // Run route-specific middleware
                foreach ($route['middleware'] as $mw) {
                    if (is_string($mw) && class_exists($mw)) {
                        $instance = new $mw();
                        if (method_exists($instance, 'handle') && $instance->handle() === false) return;
                    } elseif (is_callable($mw)) {
                        if (call_user_func($mw) === false) return;
                    }
                }
                return $this->callAction($route['action']);
            }

            // Match dynamic {parameters} in URI
            $pattern = preg_replace('#\{[^\}]+\}#', '([^/]+)', $route['uri']);
            if (preg_match("#^$pattern$#", $uri, $matches)) {
                array_shift($matches); // remove full match
                // Run route-specific middleware
                foreach ($route['middleware'] as $mw) {
                    if (is_string($mw) && class_exists($mw)) {
                        $instance = new $mw();
                        if (method_exists($instance, 'handle') && $instance->handle() === false) return;
                    } elseif (is_callable($mw)) {
                        if (call_user_func($mw) === false) return;
                    }
                }
                return $this->callAction($route['action'], $matches);
            }
        }

        // No route matched: return 404
        http_response_code(404);
        echo "404 Not Found";
    }

    // Get the base path of the application
    public function basePath()
    {
        $scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
        $scriptDir = rtrim(dirname($scriptName), '/');
        return ($scriptDir === '' || $scriptDir === '/') ? '' : $scriptDir;
    }

    // Generate a URL for a named route
    public function route($name, $params = [])
    {
        if (!isset($this->namedRoutes[$name])) {
            throw new Exception("Route name not found: $name");
        }
        $uri = $this->namedRoutes[$name];
        // Replace {param} with values from $params
        if ($params) {
            foreach ($params as $key => $value) {
                $uri = preg_replace('/\{' . $key . '\}/', $value, $uri);
            }
        }
        $base = $this->basePath();
        return $base . '/' . ltrim($uri, '/');
    }

    // Call the route action (controller method or closure)
    private function callAction($action, $params = [])
    {
        if (is_callable($action)) {
            return call_user_func_array($action, $params);
        }

        if (is_string($action)) {
            list($controller, $method) = explode('@', $action);
            require_once "controllers/$controller.php";
            $controllerInstance = new $controller;
            return call_user_func_array([$controllerInstance, $method], $params);
        }

        echo "Invalid route action.";
    }
}
