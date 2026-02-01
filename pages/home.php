<?php

$content = <<<HTML
<div class="text-center mt-5">
    <h1 class="display-4 mb-3">Добро пожаловать на MySite</h1>
    <p class="lead mb-4 text-start mx-auto" style="max-width: 800px;">
        Сделать страницу аутентификации по email и паролю.<br><br>
        Сделать страницу с формой обратной связи, на которой есть: текстовое поле, многострочное текстовое поле, радиокнопки, флажки, выпадающий список, кнопка сброса формы, кнопка отправки формы.<br><br>
        Форма обратной связи доступна только авторизованным пользователям, критерий допуска — вход в систему выполнен.<br><br>
        Все красиво сверстать используя Bootstrap. Обе формы должны обрабатываться без JS (с включенным и выключенным JS в браузере).
    </p>
    <div class="d-flex justify-content-center gap-3 flex-wrap mt-4">
HTML;

if (isset($_SESSION['auth'])) {
    $content .= <<<HTML
            <a href = "$basePath/logout" class="btn btn-primary btn-lg" > Выйти</a >
            <a href = "$basePath/feedback" class="btn btn-outline-primary btn-lg" > Обратная связь </a >
        HTML;
} else {
    $content .= <<<HTML
            <a href = "$basePath/login" class="btn btn-primary btn-lg" > Вход</a >
     HTML;
}
$content .= <<<HTML
    </div>
</div>
HTML;

return $page = [
    'title' => 'Главная',
    'content' => $content,
];