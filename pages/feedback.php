<?php

$content = <<<HTML
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <h3 class="mb-4 text-center">Форма обратной связи</h3>
                <form method="post">
                    <!-- Имя -->
                    <div class="mb-3">
                        <label class="form-label">Ваше имя</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <!-- Тема -->
                    <div class="mb-3">
                        <label class="form-label">Тема обращения</label>
                        <select name="topic" class="form-select" required>
                            <option value="">Выберите тему</option>
                            <option value="question">Вопрос</option>
                            <option value="problem">Проблема</option>
                            <option value="proposal">Предложение</option>
                        </select>
                    </div>

                    <!-- Радио кнопки -->
                    <div class="mb-3">
                        <label class="form-label d-block">Как с вами связаться?</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="contact" value="email" checked>
                            <label class="form-check-label">Email</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="contact" value="phone">
                            <label class="form-check-label">Телефон</label>
                        </div>
                    </div>

                    <!-- Чекбоксы -->
                    <div class="mb-3">
                        <label class="form-label d-block">Дополнительно</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="agree[]" value="news">
                            <label class="form-check-label">Получать новости</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="agree[]" value="data">
                            <label class="form-check-label">Согласен на обработку данных</label>
                        </div>
                    </div>

                    <!-- Сообщение -->
                    <div class="mb-4">
                        <label class="form-label">Сообщение</label>
                        <textarea name="message" class="form-control" rows="5" required></textarea>
                    </div>

                    <!-- Кнопки -->
                    <div class="d-flex gap-2">
                        <button type="reset" class="btn btn-outline-secondary w-50">Очистить</button>
                        <button type="submit" class="btn btn-primary w-50">Отправить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
HTML;

return $page = [
    'title' => 'Обратная связь',
    'content' => $content,
];