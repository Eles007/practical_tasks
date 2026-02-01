<?php

/**@var mysqli $link */
require 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['login']) && !empty($_POST['password'])) {
        $password = $_POST['password'];
        $login = $_POST['login'];
        $user = mysqli_fetch_assoc(
            mysqli_query(
                $link,
                "SELECT * FROM users WHERE login = '$login'"
            )
        );

        if (isset($user['password']) && password_verify($password, $user['password'])) {
            if (!empty($user)) {
                $_SESSION['auth'] = true;
                $_SESSION['user_id'] = $user['id'];
                $message = 'Вы успешно зашли';
                header('Location:' . $basePath);
                exit;
            } else {
                $message = "Неправильный логин или пароль!";
            }
        } else {
            $message = "Неправильный логин или пароль!";
        }
    } else {
        $message = 'Заполните форму';
    }
}

$content = <<<HTML
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="text-center mb-4">Вход</h4>
                <form method="post">
                    <div class="mb-3">
                        <label class="form-label">Логин</label>
                        <input type="text" name="login" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Пароль</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Войти</button>
                </form>
                <p class="text-center text-danger fw-bold fs-5 mt-3">$message</p>
            </div>
        </div>
    </div>
</div>
HTML;

return $page = [
    'title' => 'Аутентификации',
    'content' => $content,
];