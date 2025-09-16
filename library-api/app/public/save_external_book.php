<?php
require_once __DIR__ . '/../src/Core/bootstrap.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}

use Controllers\SearchController;

$searchController = new SearchController();
$searchController->saveExternalBook();