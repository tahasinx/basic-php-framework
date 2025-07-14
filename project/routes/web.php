<?php
// Import middleware definitions
require_once __DIR__ . '/../middlewares/AuthMiddleware.php';
require_once __DIR__ . '/../middlewares/LogMiddleware.php';

// Home page route
$router->get('/', 'HomeController@index');

// Example of a closure route
$router->get('/hello', function () {
    echo "Hello from Closure!";
});

// Dynamic user route (with named route)
$router->get('/user/{id}', 'HomeController@show', [], 'user.show');
// Render example (AJAX or normal)
$router->get('/render/{id}', 'HomeController@render_example');
// Store user (POST)
$router->post('/user/store', 'HomeController@store', [], 'user.store');
// Database example
$router->get('/db-example', 'HomeController@db_example');
// Route with AuthMiddleware (must be logged in)
$router->get('/dashboard', 'HomeController@index', [AuthMiddleware::class]);
// Route with log_middleware (logs request)
$router->get('/log', 'HomeController@index', ['log_middleware']);
