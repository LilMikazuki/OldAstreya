<?php
require_once "session_start.php";
# Получить JSON как строку
$json_str = file_get_contents('php://input');
# Получить массив
$json_data = json_decode($json_str, true, JSON_UNESCAPED_UNICODE);
checkData();

/**
 * Проверка пользовательских данных
 */
function checkData()
{
    global $json_data;
    $nickname = $json_data['nickname']; # имя пользователя
    $email = $json_data['email']; # электронная почта
    $password = $json_data['password']; # пароль

    # Проверка имени пользователя
    if (!preg_match("/^[a-zA-Z][a-zA-Z0-9-_]{5,16}$/", $nickname)) {
        $error = json_encode('Некорректный логин');
        exit($error);
    }

    # Проверка email
    if (!preg_match("/^[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}$/", $email)) {
        $error = json_encode('Некорректный email');
        exit($error);
    }

    # Проверка пароля
    if (!preg_match("/(?=^.{8,25}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/", $password)) {
        $error = json_encode('Некорректный пароль');
        exit($error);
    }

    if (checkUniqueness() == false) {
        $error = json_encode('Указанный email уже используется.');
        exit($error);
    }

    # Сохранение данных в сессии
    $_SESSION['login'] = $nickname;
    $_SESSION['email'] = $email;
    $_SESSION['password'] = password_hash($password, PASSWORD_ARGON2I);

    # Генерация кода активации аккаунта
    $verify_code = generateVerifyCode(20);

    # Отправка кода для завершения регистрации
    if(mail("{$_SESSION['email']}", "Код регистрации", "astreya.ddns.net/activation/".$verify_code, "From: mikazuki339@gmail.com"));
    {
        setcookie("verify_code", "$verify_code", time()+1200, "/", "",  0);
        $message = json_encode('Successful', JSON_UNESCAPED_UNICODE);
        echo $message;
    }
}

/**
 * Генерация кода для верификации пользователя
 *
 * @param int $strength длина генерируемой строки
 * @return string случайно сгенерированная строка
 */
function generateVerifyCode($strength = 20) {
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $input_length = strlen($permitted_chars);
    $random_string = '';

    for($i = 0; $i < $strength; $i++) {
        $random_character = $permitted_chars[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }

    return $random_string;
}

/**
 * Проверка на уникальность почты
 * @return bool результат проверки
 */
function checkUniqueness() {
    require_once "db_connect.php";
    $mysqli = connectDataBase();
    $mail = $_SESSION['email'];
    $result = $mysqli->query("SELECT * FROM `users` WHERE email = '"."$mail"."'");;
    $rows = $result->num_rows;
    if ($rows > 0) { return false; }
    else { return true; }
}