<?php

namespace app;

class Router
{
    public array $getRoutes = [];
    public array $postRoutes = [];
    public Database $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    public function get($path, $callback)
    {
        $this->getRoutes[$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->postRoutes[$path] = $callback;
    }

    public function resolve()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];
        if (strpos($path, '?') !== false) {
            $path = substr($path, 0, strpos($path, '?'));
        }

        if ($method == 'GET') {
            $callback = $this->getRoutes[$path] ?? null;
        } else {
            $callback = $this->postRoutes[$path] ?? null;
        }

        if ($callback !== null) {
            call_user_func($callback, $this);
        } else {
            http_response_code(404);
            return $this->view('404', ['title' => '404 Not Found']);
        }
    }

    public function view($view, $params = [])
    {

        foreach ($params as $key => $val) {
            $$key = $val;
        }

        ob_start();
        include_once __DIR__ . "/views/$view.php";
        $content = ob_get_clean();
        include_once __DIR__ . "./views/layout/main.php";
    }
}