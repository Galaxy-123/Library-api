<?php
require_once __DIR__ . '/../src/Core/bootstrap.php';
require_once __DIR__ . '/../src/Core/Template.php';

session_start();

use Core\Template;

$template = new Template();
$error = null;
$success = null;
$login = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if (empty($login) || empty($password)) {
        $error = 'Логин и пароль обязательны';
    } elseif ($password !== $confirmPassword) {
        $error = 'Пароли не совпадают';
    } else {
        $userModel = new Models\User();
        $existingUser = $userModel->findByLogin($login);
        
        if ($existingUser) {
            $error = 'Пользователь с таким логином уже существует';
        } else {
            if ($userModel->create($login, $password)) {
                $success = 'Регистрация прошла успешно. Теперь вы можете войти.';
                $login = '';
            } else {
                $error = 'Ошибка при регистрации';
            }
        }
    }
}

$template->set('title', 'Регистрация')
         ->set('login', $login)
         ->set('error', $error)
         ->set('success', $success)
         ->set('content', $template->render('auth/register'));

$template->display('layouts/main');