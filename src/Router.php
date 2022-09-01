<?php


namespace Freezemage\Router;

use SplMaxHeap;


final class Router
{
    private array $map = [];

    public function get(string $pattern, callable $handler): void
    {
        if (!isset($this->map['GET'])) {
            $this->map['GET'] = new PatternMap();
        }

        $this->map['GET']->insert(new Route($pattern, [], $handler));
    }

    public function process(ServerRequest $request): RoutingResult
    {
        $method = $request->getRequestMethod();
        $map = $this->map[$method];

        $patterns = $routes = [];

        $index = 1;
        foreach ($map as $route) {
            list($count, $pattern) = $this->preparePattern($route->getPattern());

            $patterns[$index] = '(' . $pattern . ')';
            $routes[$index] = $route;

            $index += $count + 1;
        }

        $regex = '#' . implode('|', $patterns) . '#uiJ';

        if (preg_match($regex, $request->getRequestUri(), $matches)) {
            unset($matches[0]); // Remove the non-group match.

            $index = array_search($request->getRequestUri(), $matches);

            $route = $routes[$index];
            $arguments = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

            $route->setArguments($arguments);

            return new RoutingResult(RoutingResult::FOUND, $route);
        }

        return new RoutingResult(RoutingResult::NOT_FOUND, null);
    }

    private function preparePattern(string $pattern): array
    {
        if (preg_match_all('/{(\w+)}/ui', $pattern, $matches)) {
            list($placeholders, $arguments) = $matches;

            $replacements = [];
            for ($i = 0; $i < count($placeholders); $i++) {
                $replacements[$placeholders[$i]] = "(?<{$arguments[$i]}>.+)";
            }

            $pattern = str_replace(array_keys($replacements), array_values($replacements), $pattern);
            return [count($placeholders), $pattern];
        }

        return [0, $pattern];
    }
}