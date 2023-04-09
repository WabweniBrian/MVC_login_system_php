<?php

namespace app\controllers;

use app\Router;

class HomeController
{
    public function index(Router $router)
    {
        session_start();
        if (!isset($_SESSION['username'])) {
            header('Location: /login');
            exit();
        }
        return $router->view('home');
    }
}