<?php require_once "php/session_start.php";?>
<!DOCTYPE html>
<html lang="ru">
<? $title = 'Создание страницы'; require_once "blocks/head.php"; ?>
<body>
<? require_once "blocks/main-nav-panel.php"; ?>
<div id="wrapper">
    <div class="title">
        <h1 class="header">Создание страницы</h1>
    </div>
    <section id="page-reg-data">
        <form method="post" name="page-reg-form" onsubmit="return false;">
            <div class="form-element">
                <label>
                    <span class="field-name">Название страницы</span>
                    <input class="form-input" name="page-name" type="text" maxlength="30" minlength="2" placeholder="Название" autocomplete="off" data-timeout="0" required/>
                    <small>Придумайте название своей страницы на Astreya. Вы смоежете изменить название.</small>
                </label>
            </div>
            <div class="form-element">
                <label>
                    <span class="field-name">Тематика страницы</span>
                    <input class="form-input" name="page-theme" type="text" maxlength="60" minlength="5" placeholder="Например: музыка, подкасты, живопись, кинематограф" autocomplete="off" data-timeout="0"/>
                    <small>Теперь нужно определиться с тематикой. Что вы создаёте?</small>
                </label>
            </div>
            <div class="form-element">
                <label>
                    <span class="field-name">Описание страницы</span>
                    <textarea class="form-input" name="page-description" spellcheck="true" maxlength="600" minlength="100" placeholder="Добавьте описание" data-timeout="0"></textarea>
                    <small>Опишите свою страницу. Вы можете пропустить этот пункт и вернуться к нему позже.</small>
                </label>
            </div>
            <div class="form-element direction-row question-box">
                <span class="field-name">Вы делаете контент для взрослых? (18+)</span>
                <label class="radio">
                    <input value="0" name="adult-radio" type="radio" checked/>
                    <i class="radio"></i>
                    <span>Нет</span>
                </label>
                <label class="radio">
                    <input value="1" name="adult-radio" type="radio"/>
                    <i class="radio"></i>
                    <span>Да</span>
                </label>
            </div>

            <div class="form-element">
                <button type="submit" class="submit">Продолжить</button>
            </div>
        </form>
    </section>
</div>
<? require_once "blocks/footer.php"; ?>
<script src="js/menu.js"></script>
<script src="js/create-page.js"></script>
</body>
</html>