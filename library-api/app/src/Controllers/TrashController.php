<?php
namespace Controllers;

use Core\Controller;
use Core\Template;
use Models\Book;

class TrashController extends Controller
{
    public function index()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login.php');
            exit;
        }

        $bookModel = new Book();
        $deletedBooks = $bookModel->findDeletedByUserId($_SESSION['user_id']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['restore_book'])) {
            $bookId = (int)$_POST['book_id'];
            
            if ($bookId && $bookModel->restore($bookId)) {
                header('Location: /trash.php?success=Книга восстановлена');
                exit;
            } else {
                header('Location: /trash.php?error=Ошибка при восстановлении книги');
                exit;
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_forever'])) {
            $bookId = (int)$_POST['book_id'];
            
            if ($bookId && $bookModel->deleteForever($bookId)) {
                header('Location: /trash.php?success=Книга полностью удалена');
                exit;
            } else {
                header('Location: /trash.php?error=Ошибка при удалении книги');
                exit;
            }
        }

        $template = new Template();
        $template->set('title', 'Корзина')
                 ->set('user', ['login' => $_SESSION['login']])
                 ->set('deletedBooks', $deletedBooks)
                 ->set('error', $_GET['error'] ?? null)
                 ->set('success', $_GET['success'] ?? null)
                 ->set('content', $template->render('trash/index'));

        $template->display('layouts/main');
    }
}