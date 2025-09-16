<?php
require_once __DIR__ . '/../src/Core/bootstrap.php';
require_once __DIR__ . '/../src/Core/Template.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}

use Core\Template;
use Models\Book;


function processUploadedFile($file) {

    $allowedTypes = ['text/plain', 'text/html'];
    $fileType = mime_content_type($file['tmp_name']);
    
    if (!in_array($fileType, $allowedTypes)) {
        return false;
    }

    if ($file['size'] > 5 * 1024 * 1024) {
        return false;
    }
    

    $content = file_get_contents($file['tmp_name']);
    

    if (!mb_check_encoding($content, 'UTF-8')) {
        $content = mb_convert_encoding($content, 'UTF-8', mb_detect_encoding($content));
    }
    
    return $content;
}

$action = $_GET['action'] ?? '';
$bookId = $_GET['id'] ?? null;
$bookModel = new Book();

switch ($action) {
    case 'create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $content = $_POST['content'] ?? '';
            

            if (!empty($_FILES['text_file']['name']) && $_FILES['text_file']['error'] === UPLOAD_ERR_OK) {
                $fileContent = processUploadedFile($_FILES['text_file']);
                if ($fileContent !== false) {
                    $content = $fileContent;
                }
            }
            
            if (empty($title)) {
                header('Location: /books.php?error=Название книги обязательно');
                exit;
            }
            
            if ($bookModel->create($_SESSION['user_id'], $title, $content)) {
                header('Location: /books.php?success=Книга успешно создана');
            } else {
                header('Location: /books.php?error=Ошибка при создании книги');
            }
            exit;
        }
        break;
        
    case 'view':
        $book = $bookModel->findById($bookId);
        if (!$book || $book['user_id'] != $_SESSION['user_id']) {
            header('Location: /books.php?error=Книга не найдена');
            exit;
        }
        
        $template = new Template();
        $template->set('title', $book['title'])
                 ->set('user', ['login' => $_SESSION['login']])
                 ->set('book', $book)
                 ->set('content', $template->render('books/view'));
        
        $template->display('layouts/main');
        break;
        
    case 'edit':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $content = $_POST['content'] ?? '';
            
            if (empty($title)) {
                header('Location: /books.php?error=Название книги обязательно');
                exit;
            }
            
            if ($bookModel->update($bookId, $title, $content)) {
                header('Location: /books.php?success=Книга успешно обновлена');
            } else {
                header('Location: /books.php?error=Ошибка при обновлении книги');
            }
            exit;
        } else {
            $book = $bookModel->findById($bookId);
            if (!$book || $book['user_id'] != $_SESSION['user_id']) {
                header('Location: /books.php?error=Книга не найдена');
                exit;
            }
            
            $template = new Template();
            $template->set('title', 'Редактирование книги')
                     ->set('user', ['login' => $_SESSION['login']])
                     ->set('book', $book)
                     ->set('content', $template->render('books/edit'));
            
            $template->display('layouts/main');
        }
        break;
        
    case 'delete':
        $book = $bookModel->findById($bookId);
        if (!$book || $book['user_id'] != $_SESSION['user_id']) {
            header('Location: /books.php?error=Книга не найдена');
            exit;
        }
        
        if ($bookModel->softDelete($bookId)) {
            header('Location: /books.php?success=Книга удалена');
        } else {
            header('Location: /books.php?error=Ошибка при удалении книги');
        }
        exit;
        
    default:
        header('Location: /books.php');
        exit;
}