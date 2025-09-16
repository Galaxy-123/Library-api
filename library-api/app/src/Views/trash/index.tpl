<div class="trash-page">
    <h2>Корзина</h2>
    
    <?php if (empty($deletedBooks)): ?>
        <p>Корзина пуста</p>
    <?php else: ?>
        <div class="deleted-books-list">
            <?php foreach ($deletedBooks as $book): ?>
                <div class="deleted-book-item">
                    <div class="book-info">
                        <h3><?= $book['title'] ?></h3>
                        <p>Удалена: <?= date('d.m.Y H:i', strtotime($book['deleted_at'])) ?></p>
                    </div>
                    <div class="book-actions">
                        <form method="POST" action="/trash.php" style="display: inline;">
                            <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                            <button type="submit" name="restore_book" class="btn btn-success">
                                Восстановить
                            </button>
                        </form>
                        <form method="POST" action="/trash.php" style="display: inline;">
                            <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                            <button type="submit" name="delete_forever" class="btn btn-danger" 
                                    onclick="return confirm('Вы уверены, что хотите полностью удалить эту книгу? Это действие нельзя отменить.')">
                                Удалить навсегда
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <div class="back-link">
        <a href="/books.php" class="btn btn-primary">Вернуться к моим книгам</a>
    </div>
</div>