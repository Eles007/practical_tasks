<?php

$content = <<<HTML
<div class="d-flex flex-column justify-content-center align-items-center" style="height: 60vh;">
    <h1 class="display-1 text-danger">404</h1>
    <h3 class="mb-3">Страница не найдена</h3>
    <p class="text-center mb-4">
        К сожалению, страница, которую вы ищете, не существует.<br>
        Возможно, вы неправильно ввели адрес.
    </p>
    <a href="/index" class="btn btn-primary">Вернуться на главную</a>
</div>
HTML;

return $page = [
    'title' => 'Ошибка',
    'content' => $content,
];