<div class="form-container">
    <h2>Регистрация</h2>
    
    <form method="POST" action="/register.php">
        <div class="form-group">
            <label for="login">Логин:</label>
            <input type="text" id="login" name="login" value="<?= $login ?? '' ?>" required>
        </div>
        
        <div class="form-group">
            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" required>
        </div>
        
        <div class="form-group">
            <label for="confirm_password">Подтвердите пароль:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
    </form>
    
    <p style="margin-top: 20px; text-align: center;">
        Уже есть аккаунт? <a href="/login.php">Войти</a>
    </p>
</div>