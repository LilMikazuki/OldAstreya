<?php
require_once "php/session_start.php";
require_once "php/db_connect.php";

/**
 * Получение данных пользователя
 * @return mixed Массив с данными пользователя либо false
 */
function getUserData()
{
    $DBH = connectDataBase(); # создаём объект подключения к БД
    $idU = $_SESSION['id'];

    # получаем информацию, о пользователе, из базы данных
    $STH = $DBH->query("SELECT `email`, `nickname`, `password`, `nickname`, `tag`, `spare_email`, `phone_number`, `birthday`, `users`.`avatar`, `roles`.`name` AS `role`, `shipAdr`.*
    FROM `users` INNER JOIN `user_role` AS `roles` ON `users`.idRole = `roles`.idRole 
    INNER JOIN `shipping_addresses` AS `shipAdr` ON `users`.`idU` = `shipAdr`.`idU` WHERE `users`.`idU` = " . "'$idU'");
    $num_rows = $STH->rowCount(); # получаем количество возвращённых строк

    if ($num_rows > 0) {
        # устанавливаем режим выборки
        $STH->setFetchMode(PDO::FETCH_ASSOC);
        $user = $STH->fetch();
        $user_data['tag'] = $user['tag'];
        $user_data['nickname'] = $user['nickname'];
        $user_data['email'] = $user['email'];
        $user_data['spare_email'] = (string)$user['spare_email'];
        $user_data['phone_number'] = (string)$user['phone_number'];
        $user_data['birthday'] = $user['birthday'];
        $user_data['role'] = (string)$user['role'];
        $user_data['full_name'] = (string)$user['full_name'];
        $user_data['address'] = (string)$user['address'];
        $user_data['apartment'] = (string)$user['apartment'];
        $user_data['city'] = (string)$user['idCity'];
        $user_data['country'] = (string)$user['idCountry'];
        $user_data['postcode'] = (string)$user['postcode'];
        $user_data['avatar'] = (string)$user['avatar'];

        if ($user_data['avatar'] == 0) {
            $user_data['avatar'] = "/content/images/avatars/default.jpg";
        } else if ($user_data['avatar'] == 1) {
            $user_data['avatar'] = "/content/images/avatars/{$user_data['nickname']}.png";
        }

        if (strtotime($user_data['birthday'])) {
            # меняем формат даты
            $user_data['birthday'] = date("d-m-Y", strtotime($user_data['birthday']));
        }

        # заменяем пустые значения на 'Нет данных';
        foreach ($user_data as $key=>$value) {
            if ($value == '' || $value == null) {
                $user_data[$key] = 'Нет данных';
            }
        }

        return $user_data;
    }
    return false;
}

