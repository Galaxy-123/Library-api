<?php
namespace Controllers;

use Core\Controller;
use Core\Template;

class SearchController extends Controller
{
    public function search()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login.php');
            exit;
        }

        $query = $_GET['q'] ?? '';
        $results = [];
        $error = null;

        if (!empty($query)) {
            try {
                $googleResults = $this->searchGoogleBooks($query);

                $mifResults = $this->searchMannIvanovFerber($query);

                $results = array_merge($googleResults, $mifResults);
            } catch (\Exception $e) {
                $error = 'Ошибка при поиске книг: ' . $e->getMessage();
            }
        }

        $template = new Template();
        $template->set('title', 'Поиск книг')
                 ->set('user', ['login' => $_SESSION['login']])
                 ->set('query', $query)
                 ->set('results', $results)
                 ->set('error', $error)
                 ->set('content', $template->render('search/index'));

        $template->display('layouts/main');
    }

    private function searchGoogleBooks($query)
    {
        $url = "https://www.googleapis.com/books/v1/volumes?q=" . urlencode($query);
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        $results = [];
        if (isset($data['items'])) {
            foreach ($data['items'] as $item) {
                $volumeInfo = $item['volumeInfo'] ?? [];
                $results[] = [
                    'source' => 'Google Books',
                    'title' => $volumeInfo['title'] ?? 'Неизвестно',
                    'authors' => isset($volumeInfo['authors']) ? implode(', ', $volumeInfo['authors']) : 'Неизвестны',
                    'description' => $volumeInfo['description'] ?? 'Описание отсутствует',
                    'thumbnail' => $volumeInfo['imageLinks']['thumbnail'] ?? null,
                    'infoLink' => $volumeInfo['infoLink'] ?? '#'
                ];
            }
        }

        return $results;
    }

    private function searchMannIvanovFerber($query)
    {
        $url = "https://www.mann-ivanov-ferber.ru/book/search.ajax?q=" . urlencode($query);
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        $results = [];
        if (isset($data['books'])) {
            foreach ($data['books'] as $book) {
                $results[] = [
                    'source' => 'Манн, Иванов и Фербер',
                    'title' => $book['title'] ?? 'Неизвестно',
                    'authors' => $book['author'] ?? 'Неизвестны',
                    'description' => $book['annotation'] ?? 'Описание отсутствует',
                    'thumbnail' => $book['cover'] ?? null,
                    'infoLink' => $book['url'] ?? '#'
                ];
            }
        }

        return $results;
    }

    public function saveExternalBook()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $content = $_POST['content'] ?? '';
            
            if (empty($title)) {
                header('Location: /search.php?error=Название книги обязательно');
                exit;
            }
            
            $bookModel = new \Models\Book();
            if ($bookModel->create($_SESSION['user_id'], $title, $content)) {
                header('Location: /books.php?success=Книга успешно сохранена');
            } else {
                header('Location: /search.php?error=Ошибка при сохранении книги');
            }
            exit;
        }
        
        header('Location: /search.php');
        exit;
    }
}