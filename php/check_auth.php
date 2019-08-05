<?php
require_once "session_start.php";

switch ($_SERVER['PHP_SELF']) {
    case "/page-settings.php":
        if (!checkAuth())
            header( 'Location: /', true, 303 );
        break;
    case "/auth.php":
        if (checkAuth())
            header( 'Location: /', true, 303 );
        break;
    default:
        break;
}

/**
 * Проверка на авторизацию
 * @return bool
 */
function checkAuth() {
    return ($_SESSION['is_auth'] == true) ? true : false;
}