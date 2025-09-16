<?php
namespace Controllers;

use Models\User;
use Models;
Use Core;
Use Core\Template;
Use Models\SharedAccess;
class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    // Регистрация пользователя
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $login = $_POST['login'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

    
            if (empty($login) || empty($password)) {
                return json_encode(['error' => 'Login and password are required']);
            }

            if ($password !== $confirmPassword) {
                return json_encode(['error' => 'Passwords do not match']);
            }

            $existingUser = $this->userModel->findByLogin($login);
            if ($existingUser) {
                return json_encode(['error' => 'User already exists']);
            }

            if ($this->userModel->create($login, $password)) {
                return json_encode(['message' => 'User registered successfully']);
            } else {
                return json_encode(['error' => 'Registration failed']);
            }
        }
    }

    public function users()
{
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login.php');
        exit;
    }

    $userModel = new User();
    $sharedAccessModel = new SharedAccess();

    $allUsers = $userModel->findAllExcept($_SESSION['user_id']);
    
    $sharedUsers = $sharedAccessModel->getSharedUsers($_SESSION['user_id']);

    $users = [];
    foreach ($allUsers as $user) {
        $users[] = [
            'id' => $user['id'],
            'login' => $user['login'],
            'has_access' => $sharedAccessModel->hasAccess($_SESSION['user_id'], $user['id'])
        ];
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['grant_access'])) {
            $guestId = (int)$_POST['user_id'];
            
            if ($guestId && $sharedAccessModel->grantAccess($_SESSION['user_id'], $guestId)) {
                header('Location: /users.php?success=Доступ предоставлен');
                exit;
            } else {
                header('Location: /users.php?error=Ошибка при предоставлении доступа');
                exit;
            }
        }
        
        if (isset($_POST['revoke_access'])) {
            $guestId = (int)$_POST['user_id'];
            
            if ($guestId && $sharedAccessModel->revokeAccess($_SESSION['user_id'], $guestId)) {
                header('Location: /users.php?success=Доступ отозван');
                exit;
            } else {
                header('Location: /users.php?error=Ошибка при отзыве доступа');
                exit;
            }
        }
    }

    $template = new Template();
    $template->set('title', 'Список участников')
             ->set('user', ['login' => $_SESSION['login']])
             ->set('users', $users)
             ->set('error', $_GET['error'] ?? null)
             ->set('success', $_GET['success'] ?? null)
             ->set('content', $template->render('users/index'));

    $template->display('layouts/main');
}
}