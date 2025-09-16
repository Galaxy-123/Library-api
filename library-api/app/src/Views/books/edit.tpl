<div class="book-edit">
    <h2>Редактирование книги</h2>
    
    <form method="POST" action="/book.php?action=edit&id=<?= $book['id'] ?>">
        <div class="form-group">
            <label for="title">Название книги:</label>
            <input type="text" id="title" name="title" value="<?= htmlspecialchars($book['title']) ?>" required>
        </div>
        
        <div class="form-group">
            <label for="content">Текст книги:</label>
            <textarea id="content" name="content" rows="15"><?= htmlspecialchars($book['content']) ?></textarea>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-success">Сохранить изменения</button>
            <a href="/book.php?action=view&id=<?= $book['id'] ?>" class="btn btn-primary">Отмена</a>
        </div>
    </form>
</div>