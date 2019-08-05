<?php
require_once "../session_start.php";
require_once "../db_connect.php";
$json_str = file_get_contents('php://input'); # получить JSON как строку
$post = json_decode($json_str, true, JSON_UNESCAPED_UNICODE); # перевод JSON в ассоциативный массив
checkData();


function checkData() {

    addPost();
}

function addPost() {
    global $post;
    try {
        $DBH = connectDataBase();
        $STH = $DBH->prepare("INSERT INTO wall_author_posts (content, idProject, sender) VALUES (?, ?, ?)");
        $params[] = $post['content'];
        $params[] = (int)$post['prj'];
        $params[] = (int)$_SESSION['id'];
        $STH->execute($params);
    }
    catch (PDOException $e) {
        exit (json_encode($e->getMessage()));
    }
}