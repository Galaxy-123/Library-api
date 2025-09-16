<div class="search-page">
    <h2>Поиск книг</h2>
    
    <form method="GET" action="/search.php" class="search-form">
        <div class="form-group">
            <input type="text" name="q" value="<?= htmlspecialchars($query) ?>" placeholder="Введите название книги..." required>
            <button type="submit" class="btn btn-primary">Искать</button>
        </div>
    </form>

    <?php if (!empty($results)): ?>
        <div class="search-results">
            <h3>Результаты поиска (<?= count($results) ?> найдено)</h3>
            
            <?php foreach ($results as $book): ?>
                <div class="search-result-item">
                    <div class="book-info">
                        <h4><?= $book['title'] ?></h4>
                        <p><strong>Автор:</strong> <?= $book['authors'] ?></p>
                        <p><strong>Источник:</strong> <?= $book['source'] ?></p>
                        <p><strong>Описание:</strong> <?= nl2br(htmlspecialchars(mb_strimwidth($book['description'], 0, 200, '...'))) ?></p>
                    </div>
                    
                    <div class="book-actions">
                        <?php if ($book['thumbnail']): ?>
                            <img src="<?= $book['thumbnail'] ?>" alt="Обложка" class="book-thumbnail">
                        <?php endif; ?>
                        
                        <a href="<?= $book['infoLink'] ?>" target="_blank" class="btn btn-primary">Подробнее</a>
                        
                        <form method="POST" action="/save_external_book.php" style="display: inline;">
                            <input type="hidden" name="title" value="<?= htmlspecialchars($book['title']) ?>">
                            <input type="hidden" name="content" value="<?= htmlspecialchars($book['description']) ?>">
                            <button type="submit" class="btn btn-success">Сохранить в мою библиотеку</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php elseif (!empty($query)): ?>
        <p>По запросу "<?= htmlspecialchars($query) ?>" ничего не найдено.</p>
    <?php endif; ?>
</div>