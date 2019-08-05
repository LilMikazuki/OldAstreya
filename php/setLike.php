<?php
require_once "db_connect.php";
require_once "session_start.php";

# получить JSON как строку
$json_str = file_get_contents('php://input');
# перевод JSON в ассоциативный массив
$like = json_decode($json_str, true, JSON_UNESCAPED_UNICODE);

try {
    $DBH = connectDataBase();
    $STH = $DBH->prepare("SELECT * FROM `likes` WHERE `idPost` = '{$like['postId']}' AND `idU` = '{$_SESSION['id']}'");
    $STH->execute();
    if ($STH->rowCount() > 0) {
        $STH = $DBH->prepare("DELETE FROM `likes` WHERE `idPost` = '{$like['postId']}' AND `idU` = '{$_SESSION['id']}'");
        $STH->execute();
    } else {
        $STH = $DBH->prepare("INSERT INTO `likes` (idPost, idU) VALUES (?, ?)");
        $params[] = $like['postId'];
        $params[] = $_SESSION['id'];
        $STH->execute($params);
    }
}
catch (PDOException $e) {
    echo json_encode($e->getMessage());
}