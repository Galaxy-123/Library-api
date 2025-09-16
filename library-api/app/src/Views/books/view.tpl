<div class="book-view">
    <h2>Просмотр книги: <?= $book['title'] ?></h2>
    
    <div class="book-meta">
        <p><strong>Создана:</strong> <?= date('d.m.Y H:i', strtotime($book['created_at'])) ?></p>
        <?php if ($book['updated_at'] != $book['created_at']): ?>
            <p><strong>Обновлена:</strong> <?= date('d.m.Y H:i', strtotime($book['updated_at'])) ?></p>
        <?php endif; ?>
    </div>
    
    <div class="book-content">
        <h3>Содержание:</h3>
        <div class="content-box">
            <?= nl2br(htmlspecialchars($book['content'] ?? 'Содержание отсутствует')) ?>
        </div>
    </div>
    
    <div class="book-actions">
        <a href="/book.php?action=edit&id=<?= $book['id'] ?>" class="btn btn-warning">Редактировать</a>
        <a href="/books.php" class="btn btn-primary">Назад к списку</a>
    </div>
</div>