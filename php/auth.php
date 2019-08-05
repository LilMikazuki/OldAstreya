<?php
require_once "session_start.php";
require_once "db_connect.php";
# Получить JSON как строку
$json_str = file_get_contents('php://input');
# Получить массив
$json_data = json_decode($json_str, true, JSON_UNESCAPED_UNICODE);
$DBH = null;
checkData();

/**
 * Проверка логина и пароля пользователя
 */
function checkData() {
    global $json_data;
    global $DBH;
    $login = $json_data['login'];
    $password = $json_data['password'];

    if (preg_match("/^[a-zA-Z][a-zA-Z0-9-_]{5,16}$/", $login) || preg_match("/^[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}$/", $login)) {
        $DBH = connectDataBase();
        $STH = $DBH->query("SELECT `idU`, `email`, `password`, `nickname`, `idRole` FROM `users` WHERE nickname = "."'$login'"." OR email="."'$login'");
        $num_rows = $STH->rowCount();
        //echo json_encode("SELECT `email`, `password`, `nickname`, `idRole` FROM `users` WHERE nickname = "."'$login'"." OR email="."'$login'");
        if ($num_rows > 0) {
            # устанавливаем режим выборки
            $STH->setFetchMode(PDO::FETCH_ASSOC);
            $user = $STH->fetch();
            if (password_verify($password, $user['password'])) {
                $_SESSION['is_auth'] = 'true';
                $_SESSION['id'] = $user['idU'];
                $_SESSION['login'] = $user['nickname'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['idRole'];
                $message = json_encode("Successful", JSON_UNESCAPED_UNICODE);
                echo $message;
            }
        }
    }
    else
        forcedExit("Пользователь с такими данными не найден.");
}

/**
 * Принудительное завершение скрипта
 * с выводом сообщения пользователю
 *
 * @param $message string (сообщение для пользователя)
 */
function forcedExit($message) {
    global $mysqli;
    $message = json_encode($message, JSON_UNESCAPED_UNICODE);
    closeDataBase($mysqli);
    exit($message);
}