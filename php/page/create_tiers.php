<?php
require_once "../session_start.php";
require_once "../db_connect.php";

$json_str = file_get_contents('php://input'); # получить JSON как строку
$tier = json_decode($json_str, true, JSON_UNESCAPED_UNICODE); # перевод JSON в ассоциативный массив
$benefits = $tier['benefits']; # перенос списка преимуществ в отдельный массив
unset($tier['benefits']); # убираем benefits из данных об уровне
$DBH = null; # объект подключения к БД
$idP = null; # идентификатор проекта
checkData(); # проерить данные на корректность
echo json_encode("Tier added");

function array_swap(array &$array, $key, $key2)
{
    if (isset($array[$key]) && isset($array[$key2])) {
        list($array[$key], $array[$key2]) = array($array[$key2], $array[$key]);
        return true;
    }

    return false;
}

/**
 * Проверка данных
 */
function checkData() {
    global $tier, $benefits, $idP, $DBH;

    # получение идентификатора проекта
    try {
        $DBH = connectDataBase(); # создание объекта подключения к БД
        $STH = $DBH->prepare("SELECT `idProject` FROM `projects` WHERE `author` = ?");
        $STH->bindParam(1,intval($_SESSION['id'])); # в качестве id-автора передаётся id-пользователя
        $STH->execute();
        $idP = $STH->fetchColumn();
        $tier['idP'] = $idP;
        array_swap($tier, 'subType', 'idP');

    }
    catch (PDOException $e) {
        exit (json_encode($e->getMessage()));
    }

    # Проверка на уникальность названия
    try {
        $STH = $DBH->prepare("SELECT `title` FROM `projects_tiers` WHERE `title` = '{$tier['tier-name']}' AND `project` = {$idP}");
        $STH->execute();
        if (($STH->rowCount() > 0)) {
            exit (json_encode("Уровень с таким названием уже существует."));
        }
    }
    catch (PDOException $e) {
        exit(json_encode($e->getMessage()));
    }

    # проверка стоимости подписки
    $tier['tier-price'] = intval($tier['tier-price']);
    if ($tier['tier-price'] < 50 || $tier['tier-price'] > 999999) {
        exit(json_encode("Минимальная стоимость подписки – 50 рублей, а максимальная 999 999 рублей"));
    }

    # проверка лимита на подписку
    $tier['tier-limit'] = ($tier['tier-limit'] == "" || $tier['tier-limit'] == null) ? "0" : $tier['tier-limit'];
    $tier['tier-limit'] = intval($tier['tier-limit']);
    if ($tier['tier-limit'] < 0 || $tier['tier-limit'] > 5000) {
        exit(json_encode("Максимальный лимит на уровень – 5000"));
    }

    # проверка типа подписки
    $tier['subType'] = intval($tier['subType']);
    switch ($tier['subType']) {
        case 1:
            break;
        case 2:
            break;
        default:
            exit(json_encode("Неверно указан тип подписки"));
    }

    # проверка отправленных данных на пустоту
    foreach ($tier as $key=>$value) {
        if (($value == "" || $value == null) && $key != "tier-description" && $key != 'tier-limit')
            exit(json_encode("Некорректные данные ".$key));
    }

    # проверка преимуществ на пустоту
    foreach ($benefits as $key=>$value) {
        if ($value == "" || $value == null)
            unset($benefits[$key]);
    }
    (count($benefits) > 0) ? true : exit(json_encode("Вы должны добавить хотя бы одно преимущество"));

    # Если все проверки пройдены, создаём уровень
    createTier();
}

/**
 * Добавление уровня
 */
function createTier() {
    global $tier, $DBH;

    echo json_encode($tier);
    $insert_id = null; # идентификатор уровня
    $params = []; # массив парметров
    # заполнение параметров
    foreach ($tier as $key=>$value) {
        $params[] = $value;
    }

    # добавление нового уровня
    try {
        $DBH = connectDataBase(); # создание объекта подключения к БД
        $STH = $DBH->prepare("INSERT INTO `projects_tiers` VALUES(null, ?, ?, ?, ?, ?, ?, ?)");
        $result = $STH->execute($params);
        if ($result) {
            $insert_id = $DBH->lastInsertId(); # получение идентификатора вставленной записи
            createBenefits($insert_id); # вызов функции добавления преимуществ
        } else {
            echo json_encode("Произошла ошибка при обновлении данных");
        }
    }
    catch (PDOException $e) { echo json_encode($e->getMessage()); }

    # Если всё хорошо, добавляем преимущества
    createBenefits($insert_id);
}

/**
 * Добавление преимуществ уровня
 *
 * @param $insert_id integer идентификатор нового уровня
 */
function createBenefits($insert_id) {
    global $benefits, $idP, $DBH;
    $DBH = connectDataBase();

    # добавление преимуществ
    foreach ($benefits as $key=>$value) {
        # формирование массива параметров
        $params[] = $value;
        $params[] = $idP;
        $params[] = $insert_id;
        # добавление в БД
        try {
            # формирование запроса
            $STH = $DBH->prepare("INSERT INTO `project_benefits` VALUES (null, ?, ?, ?)");
            $STH->execute($params);
        }
        catch (PDOException $e) { exit(json_encode($e->getMessage())); }
        unset($params); # очищение значений параметров
    }
}