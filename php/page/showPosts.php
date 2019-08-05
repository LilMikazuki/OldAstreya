<?php

require_once "php/db_connect.php";
require_once "php/session_start.php";

if (!isset($_GET['name']))
    exit("Отстутствует идентификатор");

try {
    $DBH = connectDataBase();
    $STH = $DBH->prepare("SELECT * FROM `posts` AS `p` 
    INNER JOIN `projects` AS pr on p.project = pr.idProject
    WHERE pr.name = '{$_GET['name']}'");
    $STH->execute();
    if ($STH->rowCount() > 0) {
        $STH->setFetchMode(PDO::FETCH_ASSOC);
        while (($post = $STH->fetch()) != false) {

            $STH_second = $DBH->prepare("SELECT link FROM youtube_links WHERE post = '{$post['idPost']}'");
            $STH_second->execute();
            if ($STH_second->rowCount() > 0) {
                $videoLink = $STH_second->fetch(PDO::FETCH_ASSOC);
                $videoLink = $videoLink['link'];
            } else { $videoLink = null; }

            $STH_third = $DBH->prepare("SELECT path FROM post_applications WHERE post = '{$post['idPost']}'");
            $STH_third->execute();
            if ($STH_third->rowCount() > 0) {
                $path = $STH_third->fetch(PDO::FETCH_ASSOC);
                $path = $path['path'];
            } else { $path = null; }

            $STH_fourth = $DBH->prepare("SELECT `content`, `datetime`, `nickname` 
FROM comments INNER JOIN users u on comments.idU = u.idU
WHERE `idPost` = '{$post['idPost']}'");
            $STH_fourth->execute();
            $comments = [];
            if ($STH_fourth->rowCount() > 0) {
                $idPost = $post['idPost'];
                $commentsCounter = $STH_fourth->rowCount();
                $STH_fourth->setFetchMode(PDO::FETCH_ASSOC);
                while (($comment = $STH_fourth->fetch()) != false) {
                    $comments[] = array('content' => $comment['content'], 'datetime' => $comment['datetime'], 'author' => $comment['nickname']);
                }
            } else { $commentsCounter = 0; }

            $STH_fifth = $DBH->prepare("SELECT * FROM `likes` WHERE `idPost` = 5");
            $STH_fifth->execute();
            $likesCounter = $STH_fifth->rowCount();

            $STH_fifth = $DBH->prepare("SELECT * FROM `likes` WHERE `idPost` = 5 AND idU = 2");
            $STH_fifth->execute();
            $user_is_like = $STH_fifth->rowCount();



            $posts_data[] = array('id' => $post['idPost'], 'title' => $post['title'], 'content' => $post['content'], 'datetime' => date('d M Y H:i', strtotime($post['datetime'])), 'link' => $videoLink, 'app-path' => $path, 'commentsCount' => $commentsCounter, 'comments' => $comments, 'likesCount' => $likesCounter, 'isLike' => $user_is_like);
        }
    }
}
catch (PDOException $e) {
    echo $e->getMessage();
}
$response = '';

foreach ($posts_data as $key=>$value) {
    $response .= "<div class='post' data-post-id='{$posts_data[$key]['id']}'><div class='post__header'><h1>{$posts_data[$key]['title']}</h1><span class='post__datetime'>{$posts_data[$key]['datetime']}</span></div><div class='post__content'>{$posts_data[$key]['content']}</div>";
    if (strlen($posts_data[$key]['link']) > 0)
        $response .= "<div class='post__movie'>
            <iframe width='560' height='315' src='https://www.youtube.com/embed/{$posts_data[$key]['link']}' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>
        </div>";
    $response .= "<div class='post__applications'>";
    $dir = substr($posts_data[$key]['app-path'], 3);
    if ($handle = opendir($dir)) {
        while (false !== ($file = readdir($handle))) {
            if( $file != "." && $file != "..") {
                $extension = pathinfo($dir.'/'.$file);
                $size = getFileSize($dir.'/'.$file);
                $response .= "<a href='/{$dir}/{$file}' target='_blank' class='post__app-link'><img src='/content/icons/file-types/{$extension['extension']}.svg' class='application--image' alt='приложение'><span class='application--size'>{$size}</span></a>";
            }
        }
    }
    $response .= "</div>"; # закрывает applications
    $dataLike = '';
    if ($posts_data[$key]['isLike'] === 0) {
        $like = 'like.svg';
    } else if ($posts_data[$key]['isLike'] === 1) {
        $like = 'is_like.svg';
        $dataLike = "liked";
    }
    $response .= "<div class=\"post-social\"><ul class=\"ul--social\" data-post-id='{$posts_data[$key]['id']}'><li class=\"social__li li--like\" {$dataLike}> <img src=\"/content/icons/social/{$like}\" alt=\"like\"><span class='likes-count'>{$posts_data[$key]['likesCount']}</span></li><li class=\"social__li li--comment\" data-shown='false'><img src=\"/content/icons/social/comments.svg\" alt=\"comments\"><span class='comments-count'>{$posts_data[$key]['commentsCount']}</span></li></ul><div class=\"field--comment\">";
    $response .= "<section class=\"section--comments\">";
    if (count($posts_data[$key]['comments']) > 0) {
        foreach ($posts_data[$key]['comments'] as $k => $v) {
            $response .= "<div class=\"comment\" data-shown='false'><div class=\"comment__header\"><img src=\"/content/images/avatars/astrea.png\" class=\"avatar--comment\" alt=\"avatar\"><span class=\"comment-author\">{$posts_data[$key]['comments'][$k]['author']}</span></div> <span class=\"comment-content\">{$posts_data[$key]['comments'][$k]['content']}</span> </div>";
        }
    }
    $response .=  "</section><label><img src=\"/content/images/avatars/astrea.png\" alt=\"avatar\" class=\"avatar--comment\">
 <textarea class=\"input--comment\" maxlength=\"1000\" placeholder=\"Введите комментарий\" data-post-id=\"{$posts_data[$key]['id']}\"></textarea></label></div></div>";
    $response .= "</div>"; # закрывает post
}
echo $response;

function getFileSize($file) {
    $ex = ' Кб';
    $size = filesize($file);
    $size = $size / 1024; // kb
    if ($size > 1024) {
        $ex = ' Мб';
        $size = $size / 1024; // mb
    }

    $size = round($size,1);

    return $size.$ex;
}