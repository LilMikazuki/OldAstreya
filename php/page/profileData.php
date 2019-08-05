<?php
require_once "php/session_start.php";
require_once "php/db_connect.php";

function showSubscription($name)
{
    try {
        $DBH = connectDataBase();
        $STH = $DBH->prepare("SELECT `prj`.* FROM `projects` AS `prj`
INNER JOIN subscriptions s on prj.idProject = s.idProject
INNER JOIN users u on s.idU = u.idU
WHERE u.nickname = '{$name}'");
        $STH->execute();
        $response = '';
        if ($STH->rowCount() > 0) {
            while (($result = $STH->fetch(PDO::FETCH_ASSOC)) != false) {
                $desc = (strlen($result['description']) > 100) ? mb_substr($result['description'], 0, 100) . "..." : $result['description'];
                $response .= "<div class='subscribe-box'> <header><img class='sb-cover' src='/projects/{$result['name']}/cover.png' alt='Фон'><img class='sb-avatar' src='/projects/{$result['name']}/avatar.png' alt='Аватар'></header><span class='sb-name'>{$result['name']}</span><span class='sb-description'>{$desc}</span><span class='sb-subs-count'>78 подписчиков</span></div>";
            }
            echo $response;
        } else {
            echo "Подписки отсутствуют";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function showComments($name) {
    try {
        $DBH = connectDataBase();
        $STH = $DBH->prepare("SELECT c.*, p.title as postTitle, prj.name as projectName
        FROM `comments` AS c INNER JOIN posts p on c.idPost = p.idPost
        INNER JOIN projects prj on p.project = prj.idProject
        INNER JOIN users u on c.idU = u.idU
        WHERE u.nickname = '{$name}'");
        $STH->execute();
        $response = '';
        if ($STH->rowCount() > 0) {
            while (($result = $STH->fetch(PDO::FETCH_ASSOC)) != false) {
                $response .= "<div class='comment'><img class='cm-post-cover' src='/projects/{$result['projectName']}/avatar.png' alt='Обложка поста'><div class='cm-info'><span class='cm-to'>Комментарий к записи <a href='//astreya.ddns.net/page/{$result['projectName']}'>'{$result['postTitle']}.'</a></span><span class='cm-post-author'>Автор записи:  <a href='//astreya.ddns.net/page/{$result['projectName']}'>{$result['projectName']}</a></span><span class=\"cm-content\">{$result['content']}</span><span class='cm-datetime'>{$result['datetime']}</span>
                    </div>
                </div>";
            }
            echo $response;
        } else {
            echo "Комментарии отсутствуют";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function showLikes($name) {
    try {
        $DBH = connectDataBase();
        $STH = $DBH->prepare("SELECT l.*, p.title as postTitle, prj.name as projectName
        FROM `likes` AS l INNER JOIN posts p on l.idPost = p.idPost
        INNER JOIN projects prj on p.project = prj.idProject
        INNER JOIN users u on l.idU = u.idU
        WHERE u.nickname = '{$name}'");
        $STH->execute();
        $response = '';
        if ($STH->rowCount() > 0) {
            while (($result = $STH->fetch(PDO::FETCH_ASSOC)) != false) {
                $response .= "<div class='like-box'><img class='lk-post-cover' src='/projects/{$result['projectName']}/avatar.png' alt='Обложка поста'><div class='lk-info'><span class='lk-to'>Mikazuki оценил(а) запись <a href='#'>'{$result['postTitle']}.'</a> от <a href='#'>{$result['projectName']}</a></span><span class='lk-datetime'>{$result['datetime']}</span>   </div></div>";
            }
            echo $response;
        } else {
            echo "Лайки отсутствуют";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}