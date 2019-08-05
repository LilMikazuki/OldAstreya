<?php
require_once "../session_start.php";
require_once "../db_connect.php";
$answer = [];
if (isset($_POST['action'])) {
    $answer["answer"] = '';
    switch ($_POST['action']) {
        case 'setAvatar':
            setAvatar();
            break;
        case 'setCover':
            setCover();
            break;
        case 'updateInfo':
            updateInfo();
            break;
        default:
            break;
    }
}

function setAvatar() {
    global $answer;
    if (isset($_FILES['avatar'])) {
        $avatar = $_FILES['avatar'];
        try {
            $DBH = connectDataBase();
            $STH = $DBH->prepare("SELECT `name` FROM `projects` WHERE author = '{$_SESSION['id']}'");
            $STH->execute();
            if ($STH->rowCount() > 0) {
                $result = $STH->fetch(PDO::FETCH_ASSOC);
                $pName = $result['name'];
                $destination_dir = "{$_SERVER['DOCUMENT_ROOT']}/projects/{$pName}/avatar.png";
                move_uploaded_file($avatar['tmp_name'], $destination_dir); // Перемещаем файл в желаемую директорию
                $answer['answer'] = 'successful';
                $answer['src'] = "/projects/{$pName}/avatar.png";
                echo json_encode($answer);
            }
        }
        catch (PDOException $e) {

        }
    } else {
        exit();
    }
}

function setCover() {
    global $answer;
    if (isset($_FILES['cover'])) {
        $cover = $_FILES['cover'];
        try {
            $DBH = connectDataBase();
            $STH = $DBH->prepare("SELECT `name` FROM `projects` WHERE author = '{$_SESSION['id']}'");
            $STH->execute();
            if ($STH->rowCount() > 0) {
                $result = $STH->fetch(PDO::FETCH_ASSOC);
                $pName = $result['name'];
                $destination_dir = "{$_SERVER['DOCUMENT_ROOT']}/projects/{$pName}/cover.png";
                move_uploaded_file($cover['tmp_name'], $destination_dir); // Перемещаем файл в желаемую директорию
                $answer['answer'] = 'successful';
                $answer['src'] = "/projects/{$pName}/cover.png";
                echo json_encode($answer);
            }
        }
        catch (PDOException $e) {

        }
    } else {
        exit();
    }
}

function updateInfo() {
    $oldName = '';
    try {
        $DBH = connectDataBase();
        $STH = $DBH->prepare("SELECT `name` FROM `projects` WHERE author = '{$_SESSION['id']}'");
        $STH->execute();
        if ($STH->rowCount() > 0) {
            $result = $STH->fetch(PDO::FETCH_ASSOC);
            $oldName = $result['name'];
        }
        else {
            exit("Ошибочка");
        }


        $DBH = connectDataBase();
        $STH = $DBH->prepare("UPDATE `projects` SET name =?, theme = ?, description = ? WHERE author = '{$_SESSION['id']}'");
        $params = [];
        unset($_POST['action']);
        foreach ($_POST as $key=>$value) {
            $params[] = $value;
        }
        $STH->execute($params);
        rename("{$_SERVER['DOCUMENT_ROOT']}/projects/{$oldName}", "{$_SERVER['DOCUMENT_ROOT']}/projects/{$params[0]}");
        echo json_encode("successful");
    }
    catch (PDOException $e) {
        exit(json_encode($e->getMessage()." ".print_r($params)));
    }
}