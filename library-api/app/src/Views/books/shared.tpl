<div class="shared-books">
    <h2>Библиотеки других пользователей</h2>

    <?php if (!empty($accessibleLibraries)): ?>
        <div class="libraries-list">
            <h3>Доступные библиотеки:</h3>
            <ul>
                <?php foreach ($accessibleLibraries as $library): ?>
                    <li>
                        <a href="/shared_books.php?owner_id=<?= $library['id'] ?>">
                            Библиотека пользователя: <?= $library['login'] ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php else: ?>
        <p>У вас пока нет доступа к библиотекам других пользователей</p>
    <?php endif; ?>

    <?php if ($owner): ?>
        <div class="books-list">
            <h3>Книги пользователя: <?= $owner['login'] ?></h3>
            
            <?php if (empty($books)): ?>
                <p>В этой библиотеке пока нет книг</p>
            <?php else: ?>
                <?php foreach ($books as $book): ?>
                    <div class="book-item">
                        <div class="book-info">
                            <h4><?= $book['title'] ?></h4>
                            <p>Создана: <?= date('d.m.Y H:i', strtotime($book['created_at'])) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>