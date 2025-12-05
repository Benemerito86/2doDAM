<?php
session_start();

// Autoload (manual por ahora)
require_once __DIR__ . '/../app/core/Router.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/PostController.php';
require_once __DIR__ . '/../app/controllers/ProfileController.php';

$router = new Router();

// Auth Routes
$router->add('GET', '/login', 'AuthController@login');
$router->add('POST', '/login', 'AuthController@login');
$router->add('GET', '/register', 'AuthController@register');
$router->add('POST', '/register', 'AuthController@register');
$router->add('GET', '/logout', 'AuthController@logout');
$router->add('GET', '/seed', 'AuthController@seed'); // Setup DB

// App Routes
$router->add('GET', '/', 'PostController@index');
$router->add('GET', '/post/create', 'PostController@create');
$router->add('POST', '/post/create', 'PostController@create');

// API Routes
$router->add('POST', '/api/like', 'PostController@toggleLike');
$router->add('POST', '/api/comment', 'PostController@addComment');
$router->add('POST', '/api/post/delete', 'PostController@delete');

// Profile Routes (Dynamic)
$router->add('GET', '/profile/{username}', 'ProfileController@show');

// Dispatch
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
