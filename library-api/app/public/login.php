<?php
require_once __DIR__ . '/../src/Core/bootstrap.php';
require_once __DIR__ . '/../src/Core/Template.php';

session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: /books.php');
    exit;
}

use Core\Template;

$template = new Template();
$error = null;
$login = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($login) || empty($password)) {
        $error = 'Логин и пароль обязательны';
    } else {

        $userModel = new Models\User();
        $user = $userModel->findByLogin($login);
        
        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['login'] = $user['login'];
            
            header('Location: /books.php');
            exit;
        } else {
            $error = 'Неверный логин или пароль';
        }
    }
}

$template->set('title', 'Вход')
         ->set('login', $login)
         ->set('error', $error)
         ->set('content', $template->render('auth/login'));

$template->display('layouts/main');