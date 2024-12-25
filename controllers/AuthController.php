<?php

namespace API\Controllers;

use PDO;

class AuthController {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function login($username, $password) {
        $stmt = $this->db->prepare('SELECT * FROM administradores WHERE username = :username');
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: index.php');
            exit;
        } else {
            echo "Credenciales inválidas.";
        }
    }

    public function register($username, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare('INSERT INTO administradores (username, password) VALUES (:username, :password)');
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->execute();
        header('Location: login.html');
        exit;
    }

    public function logout() {
        session_unset();
        session_destroy();
        header('Location: login.html');
        exit;
    }
}


