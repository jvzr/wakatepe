<?php

declare(strict_types = 1);

$env = getenv('environment') ?? "dev";

if ($env === "prod") {
	ini_set('display_errors', 0);
	ini_set('display_startup_errors', 0);
	error_reporting(0);
} else {
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
}

require_once "app/helper.funcs.php";
require_once "app/class.options.php";
require_once "app/class.router.php";
require_once "app/class.data.php";

$config = array(
);

$options = array_merge(new vzr\Options(), $config);

$data = new vzr\Data($options["data_path"]);

$router = new vzr\Router();
$router->addRoute(
	pattern: "/",
	function: function($params = null) {
		echo "index";
		print_arr($data);
	},
);

try {
	$match = $router->resolve($_SERVER['REQUEST_URI']);
	if($match) call_user_func_array($match->function, $match->params);
} catch(Throwable) {
	http_response_code(404);
	echo "Error 404, page not found";
}