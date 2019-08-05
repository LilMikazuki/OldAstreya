<? require_once "php/session_start.php"; ?>
<!DOCTYPE html>
<html lang="ru">
<?
require_once "blocks/head.php";
require_once "php/page/getPageInfo.php";
if (isset($_GET['name'])) {
    $pName = $_GET['name'];
    $project_data = getPageInfo($pName, "name");
    $title = $_GET['name'];
} else { die(); }
?>
<body>
<? require_once "blocks/main-nav-panel.php"; ?>
<script>
    let project = '' <?= "+ {$project_data['id']};"?>
</script>
<section class="content">
    <div class="cover-page">
        <img src="<?=$project_data['cover']?>" alt="Обложка" id="cover" class="img--cover">
        <div class="header-page">
            <img id="avatar" class="img--avatar" src="<?=$project_data['avatar']?>" alt="Аватар">
            <h1><?=$project_data['name']?></h1>
        </div>
    </div>
    <nav class="navbar--page">
        <ul class="navbar__ul">
            <li class="navbar__li active" data-for="posts">Посты</li>
            <li class="navbar__li" data-for="about">Обзор</li>
            <li class="navbar__li" data-for="wall">Стена</li>
        </ul>
    </nav>
    <section class="section--page posts active">
        <section class="section--left-part" id="posts" >
            <? require_once "php/page/showPosts.php"; ?>
        </section>
        <section class="section--right-part">
            <section class="section--tiers">
                <h2 class="subheader">Уровни</h2>
                <?php require "php/page/show_tiers.php"; getTiers(); ?>
            </section>
        </section>
    </section>
    <section class="section--page about">
        <div class="section--about left">
            <div class="div--pageSection subscribers">
                <span class="about__span--subscribers">18</span>
                подписчиков
            </div>
            <div class="div--pageSection goals">
                <h2>ЦЕЛИ</h2>
                <ul class="ul--goals">
                    <li value="1">
                        <span class="goal__title">На VS Enterprise</span>
                        <div class="goal__progress">
                            <span class="goal__progressValue">20%</span>
                            <div class="goal__line--all"></div>
                            <div class="goal__line--complete"></div>
                        </div>
                        <span class="goal__description">Очень хочу себе Visual Studio Enterprise</span>
                    </li>
                    <li value="2">
                        <span class="goal__title">На хлеб</span>
                        <div class="goal__progress">
                            <span class="goal__progressValue">20%</span>
                            <div class="goal__line--all"></div>
                            <div class="goal__line--complete"></div>
                        </div>
                        <span class="goal__description">Кушать тоже хочется</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="section--about middle">
            <div class="about__description">
                <p>Abusus non tollit usum. Accepto damno. Accessio cedit principali. Actio bonae fidei. Actio in factum concepta. Actio in ius concepta.  Actio in personam. Actio in rem. Actio noxalis. Actio poenalis. Alibi. A potiori. Argumenta ponderantur, non numerantur. Argumentum ad oculos.
                    Bis dat qui cito dat. Bonorum possessio.</p>
                <p>Casum sentit dominus. Caveat emptor. Ceteris paribus. Condicio sine qua non. Contra factum non datur argumentum. Conventio facit legam. Corpus delicti. Crescente malitia crescere debet et poena. Cuius commodum, eius debet esse incommodum. Cuius commodum, eius periculum. Curia advisare vult!
                CDamnum emergens et lucrum cessans. Deceptus pro nolente est. Duo cum faciunt idem, non est idem. CEx maleficio non oritur contractus. Ex turpi causa actio non oritur. CFalsus in uno falsus in omnibus. Fraus omnia corrumpit. CGrata, rata et accepta. CHabeat sibi! Hereditas iacens. Heres succedens in honore succedit in onere.</p>
            </div>
        </div>
        <div class="section--about right">
            <div class="div--pageSection current-tierSubscription">
                <h2 class="subheader">Текущий уровень подписки</h2> <span class="span--currentTier">Текущий уровень подписки – ЛАЙТ</span>
            </div>
            <section class="section--tiers">
                <h2 class="subheader">Уровни</h2>
                <?php getTiers(); ?>
            </section>
        </div>
    </section>
    <section class="section--page wall">
        <section class="section--wall">
            <div class="div--pageSection post-wall">
                <textarea id="wall-post-content" maxlength="3000" placeholder="Пост на стене <?=$project_data['name']?>"></textarea>
                <button id="send-post-btn" class="pulse-button pulse">Отправить</button>
            </div>
            <div class="div--pageSection posts-list">
                <? require_once "php/page/showWallPosts.php"; ?>
            </div>

        </section>
        <section class="section--tiers">
            <h2 class="subheader">Уровни</h2>
            <?php getTiers(); ?>
        </section>
    </section>
</section>
<script src="/js/menu.js"></script>
<script src="/js/textarea-resize.js"></script>
<script src="/js/page-scripts.js"></script>
</body>
</html>