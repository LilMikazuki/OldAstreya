<?php
require_once "../session_start.php";
require_once "../db_connect.php";
$json_str = file_get_contents('php://input'); # получить JSON как строку
$data = json_decode($json_str, true, JSON_UNESCAPED_UNICODE); # перевод JSON в ассоциативный массив
checkData();


function checkData() {

    subscribe();
}

function subscribe() {
    global $data;
    try {
        $DBH = connectDataBase();
        $STH = $DBH->prepare("SELECT * FROM `projects` WHERE idProject = '{$data['prj']}' AND author = '{$_SESSION['id']}'");
        $STH->execute();
        if ($STH->rowCount() > 0) {
            exit (json_encode("НЕЛЬЗЯ ПОДПИСАТЬСЯ НА СВОЮ СТРАНИЦУ"));
        }

        $STH = $DBH->prepare("INSERT INTO `subscriptions` (idU, idType, idTier, idProject) VALUES (?, ?, ?, ?)");
        $params[] =  (int)$_SESSION['id'];
        $params[] = (int)$data['type'];
        $params[] = (int)$data['tier'];
        $params[] = (int)$data['prj'];
        $STH->execute($params);

        echo json_encode("successful");
    }
    catch (PDOException $e) {
        exit (json_encode($e->getMessage()));
    }
}