<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Сайт' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?= $basePath ?>">MySite</a>
        <ul class="navbar-nav ms-auto d-flex flex-row gap-3">
            <?php
            if (isset($_SESSION['auth'])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $basePath ?>/logout">Выйти</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $basePath ?>/feedback">Обратная связь</a>
                </li>
            <?php
            else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $basePath ?>/login">Вход</a>
                </li>
            <?php
            endif; ?>
        </ul>
    </div>
</nav>

<div class="container mt-5 mb-5">
    <?= $content ?? '' ?>
</div>

<footer class="bg-light text-center py-3">
    © <?= date('Y') ?> MySite
</footer>

</body>
</html>