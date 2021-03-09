<?php

declare(strict_types = 1);

namespace vzr;

class Route {
	public function __construct(public string $pattern, public \Closure $function, public bool $loose = false) {	}
}

class Router {
	public function __construct(public array $routes = array()): void { }

	public function addRoute(string $pattern, \Closure $function): void {
		$this->routes[] = new Route(
			pattern: $pattern,
			function: $function,
		);
	}

	private function pattern_is_regex(string $pattern): bool {
		if (@preg_match($pattern, null) === false) return true;
		return false;
	}

	public function resolve(string $path): Route {
		$matched = false;

		foreach($this->routes as $route) {
			$pattern = $this->pattern;

			if (!$this->pattern_is_regex($pattern)) {
				// pattern is not a regex, so just do regular matching
				if ($path === $pattern) {
					$matched = true;

					$param_str = str_replace($pattern, "", $path);
					$params = explode("/", trim($param_str, "/"));
					$params = array_filter($params);

					break;
				}
			} else {
				// pattern is a regex so lets match it to path
				if (preg_match($pattern, $path, $matches) === 1) {
					$matched = true;

					$first_match = array_shift($matches);
					$params = $matches ?? [];

					break;
				}
			}
		}

		if (!$matched) throw new \Exception("Could not match route");

		$match = clone($route);
		$match->params = $params;

		return $match;
	}
}