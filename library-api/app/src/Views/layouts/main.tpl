<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Библиотека книг' ?></title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="container">
        <?php if (isset($user)): ?>
            <?php $this->display('partials/header'); ?>
        <?php endif; ?>

        <main>
            <?php $this->display('partials/messages'); ?>
            <?= $content ?>
        </main>

        <?php $this->display('partials/footer'); ?>
    </div>
</body>
</html>