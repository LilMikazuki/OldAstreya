<?php
require_once "php/session_start.php";
$code = $_POST['code'];
if (strcmp($code, $_COOKIE["verify_code"])) {
    setcookie("verify_code", "", time() - 3600);
    echo "Ваш аккаунт активирован. Вы будете перенаправлены на страницу входа.";
    addNewUserToDB();
}

/**
 * Добавление пользователя в базу данных
 *
 * @return false|string сообщение о результате выполнения функции
 */
function addNewUserToDB() {
    require_once "php/db_connect.php";
    $DBH = connectDataBase();

    $_SESSION['role'] = 5;
    $nickname = $_SESSION['login'];
    $email = $_SESSION['email'];
    $password = $_SESSION['password'];

    # Получение текущего количества пользователей системы
    $STH = $DBH->query("SELECT MAX(idU) FROM `users`");
    $num_rows = $STH->fetch(PDO::FETCH_COLUMN) + 1;

    # Генерация тэга
    $tag = generateTag($num_rows);

    # Массив с переменными для prepare statement
    $data = [$email, $password, $nickname, $tag];

    # Добавление записи в таблицу пользователей
    $STH = $DBH->prepare("INSERT INTO users (email, password, nickname, tag, idRole) VALUES (?, ?, ?, ?, 5)");
    $STH->execute($data);
    if ($STH) {
        $message = json_encode('Пользователь успешно зарегистрирован', JSON_UNESCAPED_UNICODE);
    }
    else {
        $message = json_encode("Не удалось зарегистрировать пользователя.", JSON_UNESCAPED_UNICODE);
    }

    return $message;
}

/**
 * Генерация тэга
 *
 * @param $id string уникальный идентификатор пользователя
 * @return string уникальный тэг пользователя
 */
function generateTag($id) {
    $tag = 1000 + (int)$id;
    return $tag;
}