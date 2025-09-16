<div class="form-container">
    <h2>Вход</h2>
    
    <form method="POST" action="/login.php">
        <div class="form-group">
            <label for="login">Логин:</label>
            <input type="text" id="login" name="login" value="<?= $login ?? '' ?>" required>
        </div>
        
        <div class="form-group">
            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Войти</button>
    </form>
    
    <p style="margin-top: 20px; text-align: center;">
        Нет аккаунта? <a href="/register.php">Зарегистрироваться</a>
    </p>
</div>