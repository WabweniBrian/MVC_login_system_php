<?php

namespace app;

use app\models\User;
use PDO;
use PDOException;

class Database
{

    public PDO $pdo;
    public string $dsn = "mysql:host=localhost;port=3306;dbname=login_23;charset=utf8";
    public static $db;

    public function __construct()
    {
        try {
            $this->pdo = new PDO($this->dsn, "root", "");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Could not establish connection to database: " . $e->getMessage();
        }

        self::$db = $this;
    }

    public function existingUser(User $user)
    {
        return $this->pdo->query("SELECT * FROM users WHERE email = '$user->email'");
    }

    public function registerUser(User $user)
    {
        $statement = $this->pdo->prepare("INSERT INTO users (username, email, password) VALUES(?,?,?)");
        $statement->execute([$user->username, $user->email, $user->hashed_password]);
    }
    public function loginUser(User $user)
    {
        $statement = $this->pdo->prepare("SELECT * FROM users WHERE email= ?");
        $statement->execute([$user->email]);
        return $statement->fetch();
    }
}