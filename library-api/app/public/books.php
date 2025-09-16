<?php
require_once __DIR__ . '/../src/Core/bootstrap.php';
require_once __DIR__ . '/../src/Core/Template.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}

use Core\Template;

$bookModel = new Models\Book();
$books = $bookModel->findByUserId($_SESSION['user_id']);

$error = $_GET['error'] ?? null;
$success = $_GET['success'] ?? null;

$template = new Template();
$template->set('title', 'Мои книги')
         ->set('user', ['login' => $_SESSION['login']])
         ->set('books', $books)
         ->set('error', $error)
         ->set('success', $success)
         ->set('content', $template->render('books/index'));

$template->display('layouts/main');