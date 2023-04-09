<?php

namespace app\controllers;

use app\helpers\Validator;
use app\models\User;
use app\Router;

class AuthController
{


    public function register(Router $router)
    {

        $userData = ['username' => '', 'email' => '', 'password' => '', 'password_confirmation' => ''];
        $errors = ['username' => '', 'email' => '', 'password' => '', 'password_confirmation' => ''];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userData['username'] = filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS);
            $userData['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $userData['password'] = filter_var($_POST['password'], FILTER_SANITIZE_SPECIAL_CHARS);
            $userData['password_confirmation'] = filter_var($_POST['password_confirmation'], FILTER_SANITIZE_SPECIAL_CHARS);
            $userData['hashed_password'] = password_hash(filter_var($_POST['password'], FILTER_SANITIZE_SPECIAL_CHARS), PASSWORD_DEFAULT);


            $user = new User();
            $user->processData($userData);

            $errors = Validator::validate(
                $userData,
                [
                    'username' => ['required', 'min:4', 'max:20', 'unique:username'],
                    'email' => ['required', 'email', 'unique:email'],
                    'password' => ['required', 'min:4'],
                    'password_confirmation' => ['required', 'match:password'],
                ]
            );

            $user->hashed_password = password_hash($user->password, PASSWORD_DEFAULT);

            if (empty(array_filter($errors))) {
                $user->registerUser();
                session_start();
                $_SESSION['username'] = $user->username;
                $_SESSION['email'] = $user->email;
                header('Location: /');
            }
        }
        return $router->view('auth/register', ['title' => 'Register', 'user' => $userData, 'errors' => $errors]);
    }


    public function login(Router $router)
    {
        $errors = ['email' => '', 'password' => ''];
        $userData = ['email' => '', 'password' => '', 'remember_me' => false];

        if (isset($_COOKIE['remember_me']) && $_COOKIE['remember_me'] == 'on') {
            $userData['email'] = $_COOKIE['email'] ?? '';
            $userData['remember_me'] = true;
        } else {
            $userData['email'] = '';
            $userData['remember_me'] = false;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userData['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $userData['password'] = filter_var($_POST['password'], FILTER_SANITIZE_SPECIAL_CHARS);
            $userData['remember_me'] = $_POST['remember_me'] ?? null;

            $user = new User();
            $user->processData($userData);

            $errors = Validator::validate(
                $userData,
                [
                    'email' => ['required'],
                    'password' => ['required'],
                ]
            );

            $user->setUserCookies($userData);

            if (empty(array_filter($errors))) {
                $userFromDb = $user->loginUser();
                if ($userFromDb && password_verify($user->password, $userFromDb['password'])) {
                    session_start();
                    $_SESSION['username'] = $userFromDb['username'];
                    $_SESSION['email'] = $user->email;
                    header("Location: /");
                    exit();
                } else {
                    $errors['credential_err'] = 'Invalid email or password.';
                }
            }
        }

        return $router->view('auth/login', ['title' => 'Login', 'user' => $userData, 'errors' => $errors]);
    }


    public function logout()
    {
        $user = new User();
        $user->logoutUser();
    }
}