<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0);

require_once '../config/config.php';
require_once '../controllers/NotasController.php';

use API\Controllers\NotasController;

session_start();

// Verificar autenticación
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Autorización requerida']);
    exit;
}

try {
    $db = getDBConnection();
    $notasController = new NotasController($db);

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $response = isset($_GET['id'])
                ? $notasController->getNotaById($_GET['id'])
                : $notasController->getNotas();
            break;

        case 'POST':
            $response = $notasController->addNota($_POST);
            break;

        case 'PUT':
            $putData = json_decode(file_get_contents('php://input'), true);
            $id = isset($_GET['id']) ? $_GET['id'] : null;

            if (!$id || empty($putData)) {
                $response = ['success' => false, 'error' => 'Datos incompletos o ID faltante'];
            } else {
                $response = $notasController->updateNota($id, $putData);
            }
            break;

        case 'DELETE':
            $id = isset($_GET['id']) ? $_GET['id'] : null;
            $response = $id
                ? $notasController->deleteNota($id)
                : ['success' => false, 'error' => 'ID faltante'];
            break;

        default:
            http_response_code(405);
            $response = ['success' => false, 'error' => 'Método no permitido'];
            break;
    }

    echo json_encode($response);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Error del servidor: ' . $e->getMessage()]);
}