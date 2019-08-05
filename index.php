<?php require_once "php/session_start.php"; ?>
<!DOCTYPE html>
<html lang="ru">
<? $title = 'Главная страница'; require_once "blocks/head.php"; ?>
<body>
<?php require_once "blocks/main-nav-panel.php";?>
<main id="main-page">
    <h1 class="headline"><span>ASTREYA</span> – КРАУДФАНДИНГОВАЯ ПЛАТФОРМА ДЛЯ ПОДДЕРЖКИ ЛЮБИМЫХ АВТОРОВ.</h1>
    <div class="main__section">
        <div class="wrapper">
            <h1 class="title">КТО ПОЛЬЗУЕТСЯ НАШЕЙ ПЛАТФОРМОЙ?</h1>
            <ul class="types-users">
                <li>Художники</li>
                <li>Музыканты</li>
                <li>Видеоблогеры</li>
                <li>Писатели</li>
                <li>Дизайнеры</li>
                <li>Фотографы</li>
                <li>Режиссёры</li>
                <li>Подкастеры</li>
            </ul>
            <h3>И другие люди, создающие интересный контент <br>и желающие получать доход от своего хобби.</h3>
        </div>
    </div>
    <div class="main__section">
        <div class="wrapper">
            <h1 class="title">ЗАЧЕМ ПОЛЬЗОВАТЬСЯ ASTREYA?</h1>
            <section class="features">
                <div class="f-unit">
                    <img src="content/icons/for-main/forecast.svg" class="f-icon" alt="Прозрачное будущее">
                    <p class="f-paragraph">Вы всегда будете знать, сколько заработаете в текущем месяце и сможете видеть статистику по доходам.</p>
					<!-- Мы спрогнозируем ваш доход на несколько
                        месяцев вперёд. Вы всегда сможете узнать,
                        сколько прибыли принесёт ваш бизнес в
                        ближайшее время. -->
                </div>
                <div class="f-unit">
                    <img src="content/icons/for-main/communication.svg" class="f-icon" alt="Прямая связь с поклонниками">
                    <p class="f-paragraph">Общайтесь со своими поклонниками напрямую.
                        Получайте обратную связь и совершенствуйте
                        свой контент.</p>
                </div>
                <div class="f-unit">
                    <img src="content/icons/for-main/exclusive-gifts.svg" class="f-icon" alt="Эксклюзивные плюшки">
                    <p class="f-paragraph">Отблагодарите своих поклонников
                        эксклюзивными подарками, которые нельзя
                        получить где-либо ещё.</p>
                </div>
            </section>
        </div>
    </div>
    <div class="main__section join">
        <div class="wrapper">
            <h1 class="title">Давай продвигать интернет-культуру вместе,
                выбери свою роль и присоединяйся к Astreya!</h1>
            <div class="role">
                <div class="role__info">
                    <h3>Автор контента</h3>
                    <p class="paragraph">Если вы создаёте собственный контент,<br>
                        присоединяйтесь в качестве автора.</p>
                    <a href="#" class="join-as">Присоединиться</a>
                </div>
                <img src="content/icons/for-main/creators.svg" alt="Роли авторов">
            </div>
            <div class="role">
                <div class="role__info">
                    <h3>Поклонник</h3>
                    <p class="paragraph">Если вы хотите поддерживать авторов,<br>
                        присоединяйтесь как поклонник.</p>
                    <a href="#" class="join-as">Присоединиться</a>
                </div>
                <img src="content/icons/for-main/social-media.svg" alt="Социализация">
            </div>
        </div>
    </div>
</main>
<? require_once "blocks/footer.php"; ?>
<script src="js/menu.js"></script>
</body>
</html>