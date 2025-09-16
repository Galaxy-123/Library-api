<?php
require_once __DIR__ . '/../src/Core/bootstrap.php';
require_once __DIR__ . '/../src/Core/Template.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}

use Core\Template;
use Models\User;
use Models\SharedAccess;

$userController = new Controllers\UserController();
$userController->users();