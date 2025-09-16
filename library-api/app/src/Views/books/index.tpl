<div class="book-list">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>Мои книги</h2>
        <a href="/trash.php" class="btn btn-warning">Корзина</a>
    </div>
    
    <?php if (empty($books)): ?>
        <p>У вас пока нет книг</p>
    <?php else: ?>
        <?php foreach ($books as $book): ?>
            <div class="book-item">
                <div class="book-info">
                    <h3><?= $book['title'] ?></h3>
                    <p>Создана: <?= date('d.m.Y H:i', strtotime($book['created_at'])) ?></p>
                </div>
                <div class="book-actions">
                    <a href="/book.php?action=view&id=<?= $book['id'] ?>" class="btn btn-primary">Просмотреть</a>
                    <a href="/book.php?action=edit&id=<?= $book['id'] ?>" class="btn btn-warning">Редактировать</a>
                    <a href="/book.php?action=delete&id=<?= $book['id'] ?>" class="btn btn-danger" onclick="return confirm('Вы уверены?')">Удалить</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div class="form-container">
    <h2>Добавить новую книгу</h2>
    <form method="POST" action="/book.php?action=create" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Название книги:</label>
            <input type="text" id="title" name="title" value="<?= $title ?? '' ?>" required>
        </div>
        <div class="form-group">
            <label for="content">Текст книги:</label>
            <textarea id="content" name="content"><?= $content ?? '' ?></textarea>
        </div>
        <div class="form-group">
            <label for="text_file">Или загрузите текстовый файл:</label>
            <input type="file" id="text_file" name="text_file" accept=".txt,.text">
            <small>Поддерживаются файлы в формате TXT</small>
        </div>
        <button type="submit" class="btn btn-success">Добавить книгу</button>
    </form>
</div>