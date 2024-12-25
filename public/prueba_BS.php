<?php
require_once '../config/config.php';

try {
    $db = getDBConnection();
    echo "Conexión a la base de datos exitosa.";
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}

