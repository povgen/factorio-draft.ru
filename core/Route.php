<?php

class Route
{
	private static $routes = [];

	public static function add(string $route, callable|array $func): void
	{
		self::$routes[$route] = $func;
	}

	public static function match(string $url): callable|array|false
	{
		if (array_key_exists($url, self::$routes)) {
			 return self::$routes[$url];
		}
		return false;
	}

	public static function callMatches(string $url): void
	{
		$match = Route::match($url);
		if (!$match) {
			echo $url.' page not found';
			return;
		}

		if (is_array($match)) {
			$className = $match[0];
			$actionName = $match[1];
			$controller = new $className();
			$controller->$actionName($_REQUEST);
		} else {
			call_user_func($match);
		}
	}
}