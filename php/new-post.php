<?php

/**
 * @param $data
 */
function checkData($data) {
    # очистка полей от нежелательного содержимого
    $data['post-title'] = strip_tags($data['post-title']); # очистка от html тэов
    $data['post-title'] =  htmlspecialchars($data['post-title']); # преобразование спец. символов в html сущности
    $data['post-title'] = trim($data['post-title']); # ошистка от лишних пробелов

    $data['post-content'] = strip_tags($data['post-content']);
    $data['post-content'] =  htmlspecialchars($data['post-content']);

    if (strlen($data['post-title']) > 120 ||strlen($data['post-title']) < 1) {
        exit(json_encode("Слишком короткий/длинный заголовок."));
    }

    if (strlen($data['post-content']) > 3000) {
        exit(json_encode("Слишком длинное содержание."));
    }

    # проверка ссылки на видео
    if ($data['post-videoLink'] != '' && $data['post-videoLink'] != null) {
        if (strlen($data['post-videoLink']) > 50) {
            exit(json_encode("Слишком длинная ссылка"));
        }

//        $youTubeLinkPattern = "/^(https?:\/\/)?([\w\.]+)\.([a-z]{2,6}\.?)(\/[\w\.]*)*\/?$/";
//        if (!preg_match($youTubeLinkPattern, $data['post-videoLink'])) {
//            exit(json_encode("Некорректная ссылка на видео"));
//        }
    }
}

/**
 * @param string $file файл
 * @param float|int $maxFileSize максимальный размер файла (1024 * N, где N - кол-во Мбайт)
 */
function checkFile($file, $maxFileSize = 1024 * 15)
{
    # допустимые расширения файлов
    $extensions = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'mpg4', 'ogv', 'mp3', 'ogg', 'oga', 'zip', 'rar', '7z', 'gz', 'pdf', 'doc', 'docx', 'txt'];

    # проверка размера файла
    $size = $size = number_format(filesize($_FILES[$file]['tmp_name']) / 1024, 2, '.', '');
    if ($size > $maxFileSize) {
        exit(json_encode("Максимальный допустимый размер файла – 15 МБ"));
    }

    # проверка расширения файла
    $extension = getExtension($_FILES[$file]['name']);
    if (array_search($extension, $extensions, true) === false) {
        exit(json_encode("Недопустимый формат файла ".$extension));
    }
}

function rus2Translite($string) {
    $converter = array(
        'а' => 'a',   'б' => 'b',   'в' => 'v',
        'г' => 'g',   'д' => 'd',   'е' => 'e',
        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
        'и' => 'i',   'й' => 'y',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n',
        'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 's',   'т' => 't',   'у' => 'u',
        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
        'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

        'А' => 'A',   'Б' => 'B',   'В' => 'V',
        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
        'О' => 'O',   'П' => 'P',   'Р' => 'R',
        'С' => 'S',   'Т' => 'T',   'У' => 'U',
        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
        'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
    );
    return strtr($string, $converter);
}

function str2url($str) {
    # переводим в транслит
    $str = rus2translit($str);
    # в нижний регистр
    $str = strtolower($str);
    # заменям все ненужное нам на "-"
    $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
    # удаляем начальные и конечные '-'
    $str = trim($str, "-");
    return $str;
}

/**
 * Получение расширения файла
 *
 * @param string $filename имя файла
 * @return mixed расширение файла
 */
function getExtension($filename) {
    $path_info = pathinfo($filename);
    return $path_info['extension'];
}

/**
 * Сохранение файлов на сервер
 * @param $POST_ID
 */
function saveFiles($POST_ID) {
    global $post_count, $project_name;
    try {
        mkdir("../projects/{$project_name}/posts/".$post_count);
        $DBH = connectDataBase();
        $STH = $DBH->prepare("INSERT INTO `post_applications` (path, post) VALUES (?, ?)");
        $STH->execute(array("../projects/{$project_name}/posts/".$post_count, $POST_ID));

        foreach ($_FILES as $key => $value) {
            $destination_dir = "../projects/{$project_name}/posts/{$post_count}/{$_FILES[$key]['name']}";
            //$destination_dir = dirname($destination_dir); // Директория для размещения файла
            move_uploaded_file($_FILES[$key]['tmp_name'], $destination_dir); // Перемещаем файл в желаемую директорию
        }
    }
    catch (Exception $e) {
        echo json_encode($e->getMessage());
    }
}

function getInfo() {
    global $project_id, $project_name, $post_count;
    try {
        $DBH = connectDataBase();
        $STH = $DBH->prepare("SELECT `projects`.`idProject`, `projects`.`name`
               FROM `posts` RIGHT JOIN `projects` ON `projects`.idProject = `posts`.project 
               WHERE `projects`.author = '{$_SESSION['id']}'");
        $STH->execute();
        if ($STH->rowCount() > 0) {
            $result = $STH->fetch(PDO::FETCH_ASSOC);
            $project_id = $result['idProject'];
            $project_name = $result['name'];
            $post_count = $STH->rowCount();
        } else {
            exit(json_encode("Проект не найден"));
        }
    }
    catch (PDOException $e) {
        exit(json_encode($e->getMessage()));
    }
}

/**
 * Добавление поста в базу данных
 */
function createPost() {
    global $project_id;
    if (isset($_FILES)) {
        foreach ($_FILES as $key => $value) {
            checkFile($key);
        }
    }

    $post_data = [$_POST['post-title'], $_POST['post-content'], $project_id];
    try {
        $DBH = connectDataBase();
        $STH = $DBH->prepare("INSERT INTO `posts` (title, content, project) VALUES (?, ?, ?)");
        $STH->execute($post_data);
        $POST_ID = $DBH->lastInsertId();
        echo json_encode("Successful");
    }
    catch (PDOException $e) {
        exit(json_encode($e->getMessage()." пост"));
    }

    if (isset($_POST['post-videoLink'])) {
        try {
            $STH = $DBH->prepare("INSERT INTO `youtube_links` (link, post) VALUES (:link, :post)");
            $STH->bindParam(":post", $POST_ID);
            $STH->bindParam(":link", $_POST['post-videoLink']);
            $STH->execute();
        }
        catch (PDOException $e) {
            exit(json_encode($e->getMessage()." линк"));
        }
    }

    saveFiles($POST_ID);
}

# подключение сторонних файлов
require_once "session_start.php";
require_once "db_connect.php";

$project_name = null;
$project_id = null;
$post_count = null;

if (!isset($_POST))
    exit(json_encode("Ошибка при получени данных"));


checkData($_POST);
getInfo();
createPost();
