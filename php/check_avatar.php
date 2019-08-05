<?php
require_once "session_start.php";
require_once "db_connect.php";
$path = '';
function check($name)
{
    try {
        $DBH = connectDataBase();
        $STH = $DBH->prepare("SELECT `avatar` FROM `users` WHERE nickname = '{$name}'");
        $STH->execute();
        if ($STH->rowCount() > 0) {
            $result = $STH->fetch(PDO::FETCH_ASSOC);
            if ($result['avatar'] == 0) {
                echo "/content/images/avatars/default.jpg";
            } else if ($result['avatar'] == 1) {
                echo "/content/images/avatars/{$name}.png";
            }

        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}