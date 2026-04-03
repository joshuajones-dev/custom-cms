<?php
declare(strict_types=1);

class App
{
    protected array $routes = [];
    protected Request $request;
    protected Response $response;
    protected Session $session;

    public function __construct()
    {
        $this->routes = Config::get('routes', []);
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
    }

    public function run(): void
    {
        $path = $this->request->path();
        $matched = $this->matchRoute($path);

        if (!$matched) {
            abort(404);
        }

        $route = $matched['route'];
        $params = $matched['params'];

        $this->request->setRouteParams($params);

        $controllerName = $route['controller'] ?? null;
        $method = $route['method'] ?? 'index';
        $middleware = $route['middleware'] ?? [];

        if (!$controllerName || !class_exists($controllerName)) {
            abort(500, 'Controller not found for route: ' . $path);
        }

        foreach ($middleware as $middlewareClass) {
            if (!class_exists($middlewareClass)) {
                abort(500, 'Middleware not found: ' . $middlewareClass);
            }

            $instance = new $middlewareClass();

            if (!$instance instanceof Middleware) {
                abort(500, 'Invalid middleware: ' . $middlewareClass);
            }

            $instance->handle($this->request);
        }

        $controller = new $controllerName();

        if (!method_exists($controller, $method)) {
            abort(500, 'Method not found: ' . $controllerName . '::' . $method);
        }

        $controller->{$method}();
    }

    protected function matchRoute(string $path): ?array
    {
        foreach ($this->routes as $route) {
            $routePath = (string) ($route['path'] ?? '');

            if ($routePath === '') {
                continue;
            }

            $params = $this->matchPath($routePath, $path);

            if ($params !== null) {
                return [
                    'route' => $route,
                    'params' => $params,
                ];
            }
        }

        return null;
    }

    protected function matchPath(string $routePath, string $actualPath): ?array
    {
        $routePath = '/' . trim($routePath, '/');
        $actualPath = '/' . trim($actualPath, '/');

        if ($routePath === '//') {
            $routePath = '/';
        }

        if ($actualPath === '//') {
            $actualPath = '/';
        }

        preg_match_all('/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/', $routePath, $matches);
        $paramNames = $matches[1] ?? [];

        $pattern = preg_replace('/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/', '([^/]+)', $routePath);
        $pattern = '#^' . $pattern . '$#';

        if (!preg_match($pattern, $actualPath, $valueMatches)) {
            return null;
        }

        array_shift($valueMatches);

        $params = [];
        foreach ($paramNames as $index => $name) {
            $params[$name] = urldecode((string) ($valueMatches[$index] ?? ''));
        }

        return $params;
    }
}