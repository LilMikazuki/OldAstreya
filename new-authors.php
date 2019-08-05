<?php require_once "php/session_start.php";?>
    <!DOCTYPE html>
    <html lang="ru">
<? $title = 'Профиль '.$_GET['login']; require_once "blocks/head.php";
require_once "php/page/profileData.php"; ?>
<body>
    <? require_once "blocks/main-nav-panel.php"; ?>
    <section class="content new-authors">
        <h1 class="new-authors__h1">Список новых авторов</h1>
       <? require_once  "php/show-new-authors.php"; ?>
    </section>
    <script src="/js/menu.js"></script>
</body>
</html>
