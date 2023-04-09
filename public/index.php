<?php

require_once __DIR__ . './../vendor/autoload.php';

use app\controllers\AuthController;
use app\controllers\HomeController;
use app\Router;


$router = new Router();


// Defining all the routes
$router->get('/', [HomeController::class, 'index']);
$router->get('/register', [AuthController::class, 'register']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);


$router->resolve();