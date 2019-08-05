<?php
require_once "php/session_start.php";
require_once "php/db_connect.php";

$response = '';
if (isset($_GET['name'])) {
    $pName = $_GET['name'];
    $project_data = getPageInfo($pName, '');
    $title = $_GET['name'];
}

try {
    $DBH = connectDataBase();
    $STH = $DBH->prepare("SELECT wap.*, u.nickname FROM `wall_author_posts` AS wap
INNER JOIN users u on wap.sender = u.idU
WHERE `idProject` = '{$project_data['id']}' AND u.idU = wap.sender");
    $STH->execute();
    if ($STH->rowCount() > 0) {
        while (($post = $STH->fetch(PDO::FETCH_ASSOC)) != false) {
            $date = date('d M Y H:i', strtotime($post['datetime']));
            $response .= "<div class='wall-post'><div class='header'><span class='post__sender'>{$post['nickname']}</span><span class='post__datetime'>{$date}</span></div><span class='post__content'>{$post['content']}</span></div>";
        }
    }
    $response .= "</div>";
}
catch (Exception $e) {
    exit (json_encode($e->getMessage()));
}

echo $response;