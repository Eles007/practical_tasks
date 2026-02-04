<?php

/**@var mysqli $link */
require 'config/db.php';

if (!isset($_SESSION['auth'])) {
    header('Location:' . $basePath . '/');
    exit;
}

$_SESSION['message'] = $_SESSION['message'] ?? '';
$old = $_SESSION['old'] ?? [];
$agree = $_POST['agree'] ?? [];

if (isset($_GET['reset'])) {
    unset($_SESSION['old']);
    $_SESSION['message'] = 'Форма очищена';
    header('Location:' . $basePath . '/feedback');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        !empty($_POST['name']) &&
        !empty($_POST['topic']) &&
        !empty($_POST['contact']) &&
        in_array('data', $_POST['agree']) &&
        !empty($_POST['text_message'])
    ) {
        $agreeJson = json_encode($agree, JSON_UNESCAPED_UNICODE);


        $stmt = $link->prepare(
            "
            INSERT INTO feedback 
            (name, topic, contact, agree, message, created_at)
            VALUES (?, ?, ?, ?, ?, NOW())
        "
        );

        $stmt->bind_param(
            "sssss",
            $_POST['name'],
            $_POST['topic'],
            $_POST['contact'],
            $agreeJson,
            $_POST['text_message']
        );

        $stmt->execute();
        $stmt->close();

        $_SESSION['message'] = 'Сообщение успешно отправлено ✅';

        // сохраняем введённые данные в сессию
        $_SESSION['old'] = $_POST;
        header('Location:' . $basePath . '/feedback');
        exit;
    } else {
        $_SESSION['message'] = 'Заполните все обязательные поля ❌';
        $_SESSION['old'] = $_POST;
    }
}

$content = "
<div class=\"container mt-5\">
  <div class=\"row justify-content-center\">
    <div class=\"col-md-8\">
      <div class=\"card shadow-sm\">
        <div class=\"card-body\">

          <h3 class=\"mb-4 text-center\">Форма обратной связи</h3>

          <form method=\"post\">

            <div class=\"mb-3\">
              <label class=\"form-label\">Ваше имя</label>
              <input type=\"text\" name=\"name\" class=\"form-control\" required
                value=\"" . htmlspecialchars($old['name'] ?? '') . "\">
            </div>

            <div class=\"mb-3\">
              <label class=\"form-label\">Тема обращения</label>
              <select name=\"topic\" class=\"form-select\" required>
                <option value=\"\">Выберите тему</option>
                <option value=\"question\" " . (($old['topic'] ?? '') === 'question' ? 'selected' : '') . ">Вопрос</option>
                <option value=\"problem\" " . (($old['topic'] ?? '') === 'problem' ? 'selected' : '') . ">Проблема</option>
                <option value=\"proposal\" " . (($old['topic'] ?? '') === 'proposal' ? 'selected' : '') . ">Предложение</option>
              </select>
            </div>

            <div class=\"mb-3\">
              <label class=\"form-label d-block\">Как с вами связаться?</label>

              <div class=\"form-check\">
                <input class=\"form-check-input\" type=\"radio\" name=\"contact\" value=\"email\"
                  " . (($old['contact'] ?? '') === 'email' ? 'checked' : '') . ">
                <label class=\"form-check-label\">Email</label>
              </div>

              <div class=\"form-check\">
                <input class=\"form-check-input\" type=\"radio\" name=\"contact\" value=\"phone\"
                  " . (($old['contact'] ?? '') === 'phone' ? 'checked' : '') . ">
                <label class=\"form-check-label\">Телефон</label>
              </div>
            </div>

            <div class=\"mb-3\">
              <label class=\"form-label d-block\">Дополнительно</label>

              <div class=\"form-check\">
                <input class=\"form-check-input\" type=\"checkbox\" name=\"agree[]\" value=\"news\"
                  " . (in_array('news', $old['agree'] ?? []) ? 'checked' : '') . ">
                <label class=\"form-check-label\">Получать новости</label>
              </div>

              <div class=\"form-check\">
                <input class=\"form-check-input\" type=\"checkbox\" name=\"agree[]\" value=\"data\" required
                  " . (in_array('data', $old['agree'] ?? []) ? 'checked' : '') . ">
                <label class=\"form-check-label\">Согласен на обработку данных</label>
              </div>
            </div>

            <div class=\"mb-4\">
              <label class=\"form-label\">Сообщение</label>
              <textarea name=\"text_message\" class=\"form-control\" rows=\"5\" required>"
                . htmlspecialchars($old['text_message'] ?? '') .
              "</textarea>
            </div>

            <div class=\"d-flex gap-2\">
              <a href=\"$basePath/feedback?reset=1\" class=\"btn btn-outline-secondary w-50\">
                    Очистить
              </a>

              <button type=\"submit\" class=\"btn btn-primary w-50\">Отправить</button>
            </div>

          </form>

          <p class=\"text-center text-danger fw-bold fs-5 mt-3\">
            " . ($_SESSION['message'] ?? '') . "
          </p>

        </div>
      </div>
    </div>
  </div>
</div>
";


return $page = [
    'title' => 'Обратная связь',
    'content' => $content,
];