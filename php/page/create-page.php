<?php
require_once "../session_start.php";
require_once "../db_connect.php";

$json_str = file_get_contents('php://input'); # получить JSON как строку
$project = json_decode($json_str, true, JSON_UNESCAPED_UNICODE); # перевод JSON в ассоциативный массив
$DBH = null; # объект подключения к БД
checkData(); # проерить данные на корректность

/**
 * Проверка данных
 */
function checkData() {
    global $project, $DBH;

    # проверка имени проекта на пустоту
    if ($project['page-name'] == '' || $project['page-name'] == null)
        exit(json_encode("Вы не указали название проекта"));

    # Проверка на уникальность названия
    try {
        $DBH = connectDataBase(); # создание объекта подключения в БД
        $STH = $DBH->prepare("SELECT `name` FROM `projects` WHERE `name` = ?");
        $STH->bindParam(1, $project['page-name']);
        $STH->execute();
        if (($STH->rowCount() > 0)) {
            exit(json_encode("Выбранное вами название уже занято."));
        }
    }
    catch (PDOException $e) { exit(json_encode($e->getMessage())); }

    # очистка полей от нежелательного содержимого
    $project['page-theme'] = strip_tags($project['page-theme']); # очистка от html тэов
    $project['page-theme'] = htmlspecialchars($project['page-theme']); # преобразование спец. символов в html сущности

    $project['page-description'] = strip_tags($project['page-description']); # очистка от html тэов
    $project['page-description'] = htmlspecialchars($project['page-description']); # преобразование спец. символов в html сущности

    $project['adult'] = intval($project['adult']);

    switch ($project['adult']) {
        case 0:
            break;
        case 1:
            break;
        default:
            exit(json_encode("Некорректные данные в поле \"Контент для взрослых\""));
    }
    $project['author'] = $_SESSION['id'];

    # Если все проверки пройдены, создаём проект
    createProject();
}

/**
 * Добавление нового проекта в базу данных
 */
function createProject() {
    global $project, $DBH;
    $params = []; # массив параметров

    # формирование массива параметров
    foreach ($project as $key=>$value) {
        $params[] = $value;
    }

    # добавление проекта в базу
    try {
        $DBH = connectDataBase(); # создание объекта подключения в БД
        $STH = $DBH->prepare("INSERT INTO `projects` (`name`, `theme`, `description`, `adult-content`, `author`) VALUES(?, ?, ?, ?, ?)");
        if ($STH->execute($params)) {
            $STH = $DBH->prepare("UPDATE `users` SET idRole = 4 WHERE idU = '{$_SESSION['id']}'");
            if ($STH->execute()) {
                $_SESSION['role'] = 4;
                echo json_encode("Проект создан");
            }
        } else {
            echo json_encode("Не удалось создать проект. Повторите попытку сейчас или попробуйте позже");
        }
    }
    catch (PDOException $e) {
        exit(json_encode($e->getMessage()));
    }
}
