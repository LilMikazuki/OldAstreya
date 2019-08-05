<!DOCTYPE html>
<html lang="ru">
<? $title = 'Регистрация'; require_once "blocks/head.php"; ?>
<body>
<? require_once "blocks/main-nav-panel.php"; ?>
    <div id="wrapper">
        <div class="title">
            <h1 class="header">Регистрация на сайте</h1>

        </div>
        <section id="registration-data">
            <form method="post" name="reg-form">
                <div class="form-element">
                    <label>
                        <span class="field-name">Имя пользователя</span>
    <!--                    <img src="content/icons/registration/user.svg" alt="Имя пользователя" oncontextmenu="return false;">-->
                        <input name="login" type="text" maxlength="16" minlength="5" autocomplete="off" data-timeout="0" required/>
                    </label>
                </div>
                <div class="form-element">
                    <label>
                        <span class="field-name">Email</span>
    <!--                    <img src="content/icons/registration/email.svg" alt="Электронная почта" oncontextmenu="return false;">-->
                        <input name="email" type="email" maxlength="25" minlength="10" autocomplete="off" data-timeout="0" required/>
                    </label>
                </div>
                <div class="form-element">
                    <label>
                        <span class="field-name">Пароль</span>
    <!--                    <img src="content/icons/registration/password.svg" alt="Пароль" oncontextmenu="return false;">-->
                        <input name="password" type="password" maxlength="25" minlength="8" autocomplete="off" data-timeout="0" required/>
                    </label>
                </div>
                <div class="form-element">
                    <button type="submit" class="submit">Продолжить</button>
                    <span>Есть аккаунт? <a href="auth.html" class="accent">Авторизируйтесь!</a></span>
                </div>
            </form>
        </section>
    </div>
<? require_once "blocks/footer.php"; ?>
    <script src="js/menu.js"></script>
    <script src="js/checkRegData.js"></script>
</body>
</html>