<?php require_once "php/check_auth.php";?>
<!DOCTYPE html>
<html lang="ru">
<? $title = 'Авторизация'; require_once "blocks/head.php"; ?>
<body>
<?php require_once "blocks/main-nav-panel.php"?>
<div id="wrapper">
    <div class="title">
        <h1 class="header">Авторизация</h1>
    </div>
    <section id="auth-data">
        <form method="post" name="auth-form">
            <div class="form-element">
                <label>
                    <span class="field-name">Email / Логин</span>
                    <input name="login" type="text" maxlength="30" minlength="5" autocomplete="off" data-timeout="0" required/>
                </label>
            </div>
            <div class="form-element">
                <label>
                    <span class="field-name">Пароль</span>
                    <input name="password" type="password" maxlength="25" autocomplete="off" data-timeout="0" required/>
                </label>
            </div>
            <div class="form-element direction-row">
                <div class="checkbox-wrapper">
                    <input type="checkbox" id="rememberCheckbox" name="rememberMe"/>
                    <div class="checkbox"><i class="fa fa-check"></i></div>
                    <label for="rememberCheckbox"><span>Запомнить</span></label>
                </div>
                <button type="submit" class="submit">Войти</button>
            </div>

            <div class="form-element direction-row">
                <span>Нет аккаунта? <a href="//astreya.ddns.net/registration" class="accent">Зарегистрируйтесь!</a></span>
                <span><a href="//astreya.ddns.net/auth" class="accent">Забыли пароль?</a></span>
            </div>
        </form>
    </section>
</div>
<? require_once "blocks/footer.php"; ?>
<script src="js/checkAuthData.js"></script>
<script src="js/menu.js"></script>
</body>
</html>