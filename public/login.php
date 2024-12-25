<?php

require_once '../config/config.php';
require_once '../controllers/AuthController.php';

use API\Controllers\AuthController;

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $db = getDBConnection();
    $authController = new AuthController($db);

    // Verificar credenciales
    $stmt = $db->prepare('SELECT * FROM administradores WHERE username = :username');
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Guardar la información del usuario en la sesión
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Redireccionar a la página de gestión de notas
        header('Location: ../Views/notas.html');
        exit;
    } else {
        echo "Credenciales inválidas.";
    }
}

