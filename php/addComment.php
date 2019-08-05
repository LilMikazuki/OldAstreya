<?php
require_once "session_start.php";
require_once "db_connect.php";

# получить JSON как строку
$json_str = file_get_contents('php://input');
# перевод JSON в ассоциативный массив
$comment = json_decode($json_str, true, JSON_UNESCAPED_UNICODE);

try {
    $DBH = connectDataBase();
    $STH = $DBH->prepare("INSERT INTO `comments` (content, idPost, idU) VALUES (:content, :idPost, :idUser)");
    $STH->bindParam(':content', $comment['content']);
    $STH->bindParam(':idPost', $comment['postId']);
    $STH->bindParam(':idUser', $_SESSION['id']);
    $STH->execute();

    echo json_encode("<div class=\"comment\"><div class=\"comment__header\"><img src=\"/content/images/avatars/astrea.png\" class=\"avatar--comment\" alt=\"avatar\"><span class=\"comment-author\">{$_SESSION['login']}</span></div><span class=\"comment-content\">{$comment['content']}</span></div>");
}
catch (PDOException $e) {
    echo json_encode($e->getMessage());
}