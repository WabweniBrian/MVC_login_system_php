<?php

namespace app\models;

use app\Database;

class User
{
    public ?string $username = null;
    public ?string $email = null;
    public ?string $password = null;
    public ?string $password_confirmation = null;
    public ?string $hashed_password = null;
    public ?string $remember_me = null;



    public function processData($user)
    {
        $this->username = $user['username'] ?? null;
        $this->email = $user['email'];
        $this->password = $user['password'];
        $this->password_confirmation = $user['password_confirmation'] ?? null;
        $this->remember_me = $user['remember_me'] ?? false;
    }

    public function setUserCookies($user)
    {
        // Set remember me cookie if checked
        if (isset($user['remember_me']) && $user['remember_me'] == 'on') {
            // Set a cookie to remember the user
            setcookie('remember_me', 'on', time() + 3600 * 24 * 30);
            setcookie('email', $this->email, time() + 3600 * 24 * 30);
            $this->remember_me = true;
        } else {
            // If the checkbox is not checked, delete the cookie
            setcookie('remember_me', '', time() - 3600);
            setcookie('email', '', time() - 3600);
            $this->remember_me = false;
        }
    }

    public function registerUser()
    {
        Database::$db->registerUser($this);
    }

    public function loginUser()
    {
        return Database::$db->loginUser($this);
    }

    public function logoutUser()
    {
        session_start();
        session_destroy();
        header("Location: /");
    }
}