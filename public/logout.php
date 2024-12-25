<?php


require_once '../config/config.php';
require_once '../controllers/AuthController.php';

use API\Controllers\AuthController;

$authController = new AuthController(getDBConnection());
$authController->logout();


