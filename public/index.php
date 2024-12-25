<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit;
}

// Mostrar el dashboard o página principal para usuarios autenticados
echo "Bienvenido, " . htmlspecialchars($_SESSION['username']) . "!";


