<?php
require_once "../session_start.php";
require_once "../db_connect.php";

/**
 * Обновление личных данных пользователя
 */
function updateUserData()
{
    global $update_data, $table;
    $params = []; # массив парметров
    $DBH = connectDataBase(); # объект подключения к БД
    # формируем запрос
    $query = "UPDATE `{$table}` SET ";
    foreach ($update_data as $key=>$value) {
        $query .= "`{$key}` = ?, ";
    }
    $query = substr($query, 0, -2);
    $query .= " WHERE `idU` = {$_SESSION['id']}";
    $statement = $DBH->prepare($query);
    # заполнение параметров
    foreach ($update_data as $key=>$value) {
        $params[] = $value;
    }

    try {
        $result = $statement->execute($params);
        if ($result) {
            echo json_encode("Данные обновлены");
        } else {
            echo json_encode("Произошла ошибка при обновлении данных");
        }
    }
    catch (PDOException $e) { echo json_encode($e->getMessage()); }
}

/**
 * Проверка и корректировка отправленных данных
 */
function checkData() {
    global $table, $update_data;
    if ($table == 'users') {
        if (array_key_exists('birthday', $update_data)) {
            if (strtotime($update_data['birthday'])) {
                $update_data['birthday'] = date("Y-m-d", strtotime($update_data['birthday']));
            } else {
                exit(json_encode("Неверный формат даты рождения"));
            }
        }
    }
    elseif ($table == 'shipping_addresses') {
        $t = 1;
        /*
         * Проверка адреса доставки
         */
    }
}

# получить JSON как строку
$json_str = file_get_contents('php://input');
# данные в виде массива
$update_data = json_decode($json_str, true, JSON_UNESCAPED_UNICODE);
# таблица, в которой будут изменены данные, по умолчанию users
$table = ($update_data["section"] == "shipping-addresses") ? "shipping_addresses"  : "users";
unset($update_data["section"]);
# проверить данные
checkData();
# обновить данные
updateUserData();