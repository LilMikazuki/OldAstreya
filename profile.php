<?php require_once "php/session_start.php";?>
<!DOCTYPE html>
<html lang="ru">
<? $title = 'Профиль '.$_GET['login']; require_once "blocks/head.php";
require_once "php/page/profileData.php"; ?>
<body>
<? require_once "blocks/main-nav-panel.php"; ?>
<div id="wrapper">
    <div id="profile">
        <div id="profile-l">
            <img src="<?check($_GET['login']);?>" alt="Аватар" id="user-avatar">
            <h3 id="username"><?=$_GET['login']?></h3>
            <span id="status" class="p-info"><? if ($_GET['login'] != 'Mikazuki') echo 'Подписчик';
            else echo 'Автор';
                ?></span>
            <div class="line"></div>
            <!--<span id="reg-date" class="p-info">На сайте с<br>апреля 2019</span>-->
        </div>
        <div id="profile-r">
            <nav id="profile-nav">
                <ul class="nav-list">
                    <li tabindex="5" data-for="subscribed-to" class="active" >Поддерживает</li>
                    <li tabindex="6" data-for="comments-list">Комментарии</li>
                    <li tabindex="7" data-for="likes-list">Лайки</li>
                </ul>
            </nav>
            <section class="p-section active" id="subscribed-to">
                <? showSubscription($_GET['login']); ?>
                <!--<div class="subscribe-box">
                    <header>
                        <img class="sb-cover" src="/content/creators/I%20See%20You/cover.jpg" alt="Фон">
                        <img class="sb-avatar" src="/content/creators/I%20See%20You/avatar.png" alt="Аватар">
                    </header>
                    <span class="sb-name">I See You</span>
                    <span class="sb-description">Фотографии милых и ничего неподозревеющих животных</span>
                    <span class="sb-subs-count">78 подписчиков</span>
                </div>
                <div class="subscribe-box">
                    <header>
                        <img class="sb-cover" src="/content/creators/Piano%20world/cover.jpg" alt="Фон">
                        <img class="sb-avatar" src="/content/creators/Piano%20world/avatar.png" alt="Аватар">
                    </header>
                    <span class="sb-name">Piano world</span>
                    <span class="sb-description">Фортепьяно-каверы на популярные треки.</span>
                    <span class="sb-subs-count">96 подписчиков</span>
                </div>
                <div class="subscribe-box">
                    <header>
                        <img class="sb-cover" src="/content/creators/Гильдия%20искусств/cover.jpg" alt="Фон">
                        <img class="sb-avatar" src="/content/creators/Гильдия%20искусств/avatar.png" alt="Аватар">
                    </header>
                    <span class="sb-name">Гильдия искусства</span>
                    <span class="sb-description">Арты, скетчи, портреты.</span>
                    <span class="sb-subs-count">217 подписчиков</span>
                </div>-->
            </section>
            <section class="p-section" id="comments-list">
                <? showComments($_GET['login']); ?>
                <!--<div class="comment">
                    <img class="cm-post-cover" src="/content/creators/I%20See%20You/notes/post_1.jpg" alt="Обложка поста">
                    <div class="cm-info">
                        <span class="cm-to">Комментарий к записи <a href="#">"Флитр в мире попугов реален."</a></span>
                        <span class="cm-post-author">Автор записи:  <a href="#">I See You</a></span>
                        <span class="cm-content">Пекпеки прекрасны, слава пекпекам! Куда скинуть деньги на черемпшу?</span>
                        <span class="cm-datetime">20 апреля 2019 в 12:45</span>
                    </div>
                </div>
                <div class="comment">
                    <img class="cm-post-cover" src="/content/creators/I%20See%20You/notes/post_1.jpg" alt="Обложка поста">
                    <div class="cm-info">
                        <span class="cm-to">Комментарий к записи <a href="#">"Флитр в мире попугов реален."</a></span>
                        <span class="cm-post-author">Автор записи:  <a href="#">I See You</a></span>
                        <span class="cm-content">Пекпеки прекрасны, слава пекпекам! Куда скинуть деньги на черемпшу?
                            Пекпеки прекрасны, слава пекпекам! Куда скинуть деньги на черемпшу?
                            Пекпеки прекрасны, слава пекпекам! Куда скинуть деньги на черемпшу?Пекпеки прекрасны, слава пекпекам! Куда скинуть деньги на черемпшу?
                            Пекпеки прекрасны, слава пекпекам! Куда скинуть деньги на черемпшу?Пекпеки прекрасны, слава пекпекам! Куда скинуть деньги на черемпшу?
                            Пекпеки прекрасны, слава пекпекам! Куда скинуть деньги на черемпшу?Пекпеки прекрасны, слава пекпекам! Куда скинуть деньги на черемпшу?
                            Пекпеки прекрасны, слава пекпекам! Куда скинуть деньги на черемпшу?</span>
                        <span class="cm-datetime">20 апреля 2019 в 12:45</span>
                    </div>
                </div>
                <div class="comment">
                    <img class="cm-post-cover" src="/content/creators/I%20See%20You/notes/post_1.jpg" alt="Обложка поста">
                    <div class="cm-info">
                        <span class="cm-to">Комментарий к записи <a href="#">"Флитр в мире попугов реален."</a></span>
                        <span class="cm-post-author">Автор записи:  <a href="#">I See You</a></span>
                        <span class="cm-content">Пекпеки прекрасны, слава пекпекам! Куда скинуть деньги на черемпшу?
                            Пекпеки прекрасны, слава пекпекам! Куда скинуть деньги на черемпшу?
                            Пекпеки прекрасны, слава пекпекам! Куда скинуть деньги на черемпшу?</span>
                        <span class="cm-datetime">20 апреля 2019 в 12:45</span>
                    </div>
                </div>-->
            </section>
            <section class="p-section" id="likes-list">
                <? showLikes($_GET['login']); ?>
               <!-- <div class="like-box">
                    <img class="lk-post-cover" src="/content/creators/I%20See%20You/notes/post_1.jpg" alt="Обложка поста">
                    <div class="lk-info">
                        <span class="lk-to">Mikazuki оценил(а) запись <a href="#">"Флирт в мире попугов реален."</a> от <a href="#">I See You</a></span>
                        <span class="lk-datetime">20 апреля 2019 в 12:43</span>
                    </div>
                </div>
                <div class="like-box">
                    <img class="lk-post-cover" src="/content/creators/I%20See%20You/notes/post_1.jpg" alt="Обложка поста">
                    <div class="lk-info">
                        <span class="lk-to">Mikazuki оценил(а) запись <a href="#">"Флирт в мире попугов реален."</a> от <a href="#">I See You</a></span>
                        <span class="lk-datetime">20 апреля 2019 в 12:43</span>
                    </div>
                </div>
                <div class="like-box">
                    <img class="lk-post-cover" src="/content/creators/I%20See%20You/notes/post_1.jpg" alt="Обложка поста">
                    <div class="lk-info">
                        <span class="lk-to">Mikazuki оценил(а) запись <a href="#">"Флирт в мире попугов реален."</a> от <a href="#">I See You</a></span>
                        <span class="lk-datetime">20 апреля 2019 в 12:43</span>
                    </div>
                </div>-->
            </section>
        </div>
    </div>
</div>
<script src="/js/menu.js"></script>
<script src="/js/profile-control.js"></script>
</body>
</html>