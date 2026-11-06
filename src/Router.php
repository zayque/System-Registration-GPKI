<?php
declare(strict_types=1);

namespace App;

final class Router
{
    /** @var array<int, array{0:string,1:string,2:callable}> */
    private array $routes = [];

    public function get(string $pattern, callable $handler): void { $this->routes[] = ['GET', $pattern, $handler]; }
    public function post(string $pattern, callable $handler): void { $this->routes[] = ['POST', $pattern, $handler]; }

    public function dispatch(string $method, string $uri): void
    {
        $path = rtrim(parse_url($uri, PHP_URL_PATH) ?: '/', '/') ?: '/';
        foreach ($this->routes as [$m, $pattern, $handler]) {
            if ($m !== $method) continue;
            $regex = '#^' . preg_replace('#\{(\w+)\}#', '(?P<$1>[^/]+)', $pattern) . '$#';
            if (preg_match($regex, $path, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $handler(...array_values($params));
                return;
            }
        }
        abort(404);
    }
}
