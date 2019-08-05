<?php
require_once "php/session_start.php";
require_once "php/db_connect.php";

$DBH = null;

/**
 * Получение информации о странице
 *  *
 * @param $data
 * @param $type
 * @return mixed
 */
function getPageInfo($data, $type) {
    global $DBH;
    try {
        $DBH = connectDataBase();
        if ($type == 'name') {
            $STH = $DBH->prepare("SELECT * FROM `projects` WHERE `name` = :data");
        } else {
            $STH = $DBH->prepare("SELECT * FROM `projects` WHERE `author` = :data");
        }
        $STH->bindParam(':data', $data);
        $STH->execute();
        if ($STH->rowCount() > 0) {
            $result = $STH->fetch(PDO::FETCH_ASSOC);
            $project_data['id'] = $result['idProject'];
            $project_data['name'] = $result['name'];
            $project_data['theme'] = $result['theme'];
            $project_data['description'] = $result['description'];
            $project_data['adult'] = $result['adult-content'];
            $project_data['subscribers'] = $result['subscribers'];
            $project_data['monthly_income'] = $result['monthly_income'];
            $project_data['income_per_item'] = $result['income_per_item'];
            $project_data['total_income'] = $result['total_income'];
            $project_data['opening_date'] = $result['opening_date'];
            $project_data['avatar'] = $result['profile_photo'];
            $project_data['cover'] = $result['cover_photo'];
            $project_data['author'] = $result['author'];
            $project_data = checkConstraint($project_data);
        }
    }
    catch (PDOException $e) {
        exit (json_encode($e->getMessage()));
    }

    return $project_data;
}

function checkConstraint($data) {
    if ($data['adult'] == '1') {
        global $DBH;
        $STH = $DBH->prepare("SELECT `birthday` FROM `users` WHERE `idU` = '{$_SESSION['id']}'");
        try {
            $STH->execute();
            if ($STH->rowCount() > 0) {
                $result = $STH->fetch(PDO::FETCH_ASSOC);
                $bDay = $result['birthday'];
                $born = new DateTime($bDay); // дата рождения
                $age = $born->diff(new DateTime)->format('%y');
                if ($age <= 18) {
                    echo "<h1>Если вам больше 18 лет, укажите дату рождения в своём профиле.</h1><script>alert('Страница содержит контент, предназначенный только для лиц старше 18 лет');</script>";
                    die();
                }
            }
        }
        catch (Exception $e) {
            exit (json_encode($e->getMessage()));
        }
    }

    # проверка аватарки
    if ($data['avatar'] == '0') {
        $data['avatar'] = "/projects/default/avatar_default.png";
    } else  {
        $data['avatar'] = "/projects/{$data['name']}/avatar.{$data['avatar']}";
    }
    # проверка обложки
    if ($data['cover'] == '0') {
        $data['cover'] = "/projects/default/cover_default.png";
    } else  {
        $data['cover'] = "/projects/{$data['name']}/cover.{$data['cover']}";
    }

    return $data;
}