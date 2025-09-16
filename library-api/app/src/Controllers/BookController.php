<?php
namespace Controllers;

use Core\Controller;
use Core\Template;
use Models\Book;
use Models\SharedAccess;
use Models\User;

class BookController extends Controller
{
    public function sharedBooks()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login.php');
            exit;
        }

        $sharedAccessModel = new SharedAccess();
        $bookModel = new Book();
        $userModel = new User();

        $ownerId = isset($_GET['owner_id']) ? (int)$_GET['owner_id'] : 0;
        
        if ($ownerId && !$sharedAccessModel->hasAccess($ownerId, $_SESSION['user_id'])) {
            header('Location: /books.php?error=Нет доступа к этой библиотеке');
            exit;
        }

        $books = [];
        $owner = null;
        
        if ($ownerId) {
            $books = $bookModel->findByUserId($ownerId);
            $owner = $userModel->findById($ownerId);
        }

        $accessibleLibraries = $sharedAccessModel->getAccessibleLibraries($_SESSION['user_id']);

        $template = new Template();
        $template->set('title', 'Библиотека пользователя')
                 ->set('user', ['login' => $_SESSION['login']])
                 ->set('books', $books)
                 ->set('owner', $owner)
                 ->set('accessibleLibraries', $accessibleLibraries)
                 ->set('error', $_GET['error'] ?? null)
                 ->set('success', $_GET['success'] ?? null)
                 ->set('content', $template->render('books/shared'));

        $template->display('layouts/main');
    }
}