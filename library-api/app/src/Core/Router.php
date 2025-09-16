<?php
namespace Core;

class Router {
    private $routes = []; 

    public function add($method, $uri, $controller, $action) {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function dispatch() {
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $requestMethod = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && $route['uri'] === $requestUri) {

                $controllerName = "Controllers\\" . $route['controller'];
 
                $controller = new $controllerName();
                
                return $controller->{$route['action']}();
            }
        }
        http_response_code(404);
        
        return json_encode(['error' => 'Route not found']);
    }
}