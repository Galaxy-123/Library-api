<div class="users-list">
    <h2>Список участников</h2>

    <?php if (empty($users)): ?>
        <p>Других участников пока нет</p>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Логин</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['login'] ?></td>
                        <td>
                            <?php if ($user['has_access']): ?>
                                <span class="access-granted">Доступ предоставлен</span>
                                <form method="POST" action="/users.php" style="display: inline; margin-left: 10px;">
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                    <button type="submit" name="revoke_access" class="btn btn-warning">
                                        Отозвать доступ
                                    </button>
                                </form>
                            <?php else: ?>
                                <form method="POST" action="/users.php" style="display: inline;">
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                    <button type="submit" name="grant_access" class="btn btn-success">
                                        Дать доступ к библиотеке
                                    </button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>