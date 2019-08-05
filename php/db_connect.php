<?php
/**
 * Подключение к БД
 *
 * @param string $db_server ip-адрес сервера
 * @param string $db_user имя пользователя
 * @param string $db_password пароль
 * @param string $db_name название БД
 * @return PDO экземпляр объекта подключения к базе данных
 */
function connectDataBase($db_server = '127.0.0.1', $db_user = 'root', $db_password = 'Fhvty99', $db_name = 'astreya') {
    $DBH = null;
    try {
        # Пытаемся соединиться c базой данных
        $DBH = new PDO("mysql:host=$db_server;dbname=$db_name", $db_user, $db_password);
        $DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    };

    return $DBH ;
}

/**
 * Закрытие соединения с БД
 * @param $mysqli mysqli объект подключения к БД
 */
function closeDataBase($mysqli) {
    //$mysqli->close(); // Закрываем соединение
}