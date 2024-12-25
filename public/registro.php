<?php

require_once '../config/config.php';
require_once '../controllers/AuthController.php';

use API\Controllers\AuthController;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['password_confirm'];

    if ($password !== $passwordConfirm) {
        echo "Las contraseñas no coinciden.";
        exit;
    }

    $db = getDBConnection();
    $authController = new AuthController($db);
    $authController->register($username, $password);
}


