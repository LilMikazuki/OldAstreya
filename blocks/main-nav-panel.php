<nav id="nav-panel" data-minimize="no">
    <div class="nav-element" id="logo">
        <a  href="//astreya.ddns.net"><img src='/content/icons/logo.png' alt='Фолбэк' oncontextmenu='return false;'></a>
    </div>
    <ul class="nav-list">
        <li><a href='//astreya.ddns.net/new/' class='nav-link'>Новое</a></li>
        <li><a href='//astreya.ddns.net/popular' class='nav-link'>Популярное</a></li>
        <? if (isset($_SESSION['is_auth']) && boolval($_SESSION['is_auth']) == true): ?>
            <li class="nav-element avatar">
                <img id='nav-avatar' src='<? require_once "php/check_avatar.php"; check($_SESSION['login'])?>' alt='Аватар'>
                <ul class="profile-menu" hidden>
                    <li><a href="//astreya.ddns.net/profile/<?=$_SESSION['login'];?>">Мой профиль</a></li>
                    <li><a href="//astreya.ddns.net/profile/<?=$_SESSION['login'];?>/settings">Настройки</a></li>
                    <? if ((integer)$_SESSION['role'] == 4): ?>
                        <li><a href="//astreya.ddns.net/page-settings">Cтраница</a></li>
                    <? endif; ?>
                    <li><a href="//astreya.ddns.net/logout">Выйти</a></li>
                </ul>

            <!--<li class='nav-element'><img id='nav-search' src='/content/icons/search.svg' alt='Поиск'></li>
            <li class='nav-element'><img id='nav-notifications' src='/content/icons/notifications-false.svg' alt='Уведомления'></li>-->
            <script src="/js/profile-menu.js"></script>
        <? else: ?>
            <li><a href='//astreya.ddns.net/auth' class='nav-link'>Вход</a></li>
            <li><a href='//astreya.ddns.net/registration' class='nav-link'>Регистрация</a></li>
        <? endif; ?>
    </ul>
</nav>