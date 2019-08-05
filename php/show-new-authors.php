<?php
require_once "php/db_connect.php";
$response = '';
try {
    $DBH = connectDataBase();
    $STH = $DBH->prepare("SELECT `name`, `theme`, `opening_date` FROM `projects` WHERE `opening_date` >= ADDDATE(current_date(), -30)");
    $STH->execute();
    if ($STH->rowCount() > 0) {
        while (($result = $STH->fetch(PDO::FETCH_ASSOC)) != false) {
            $date = date("d M Y", strtotime($result['opening_date']));
            $response .= "<div class='new-author'><div class='new-author__header'><a href='//astreya.ddns.net/page/{$result['name']}'><img src='/projects/{$result['name']}/avatar.png'><span class='new-author__name'>{$result['name']}</span></a></div>
            <span class='new-author__regDate'>Дата создания: {$date}</span>
            <span class='new-author__theme'>Тема: {$result['theme']}</span>
        </div>";
        }
        echo $response;
    }
}
catch (PDOException $e) {
    echo json_encode($e->getMessage());
}