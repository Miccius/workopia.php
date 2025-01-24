<?php
require '../helpers.php';
require __DIR__ . '/../vendor/autoload.php';

use Framework\Router;

//require basePath('Framework/Router.php');
//require basePath('Framework?databese.php');
/* 
spl_autoload_register(function($class) {

    $path = basePath('Framework/' . $class .'.php');
    if(file_exists($path)) {
        require $path;
    }

});
*/

// Instatiate the rauter
$router = new Router();

// Get routes
$routes = require basePath('routes.php');

// Get current URI and HTTP method
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

//inspectAndDie($uri);


$router->route($uri);

//inspect($uri);
//inspect($method);
//inspectAndDie($uri);




