<?php
require_once "php/session_start.php";
if ($_GET['login'] != $_SESSION['login']) {
    header('Location: //astreya.ddns.net');
    exit();
} else {
    require_once "php/profile/getUserData.php";
    $user_data = getUserData();
}
?>
<!DOCTYPE html>
<html lang="ru">
<? $title = 'Настройки профиля';
require_once "blocks/head.php"; ?>
<body>
<? require_once "blocks/main-nav-panel.php"; ?>
<div id="wrapper">
   <section id="p-settings">
       <h1>Моя учётная запись</h1>
       <section id="l-sec">
            <div class="p-setting-element" data-state="default" id="main-settings">
                <img id="avatar" src="<?=$user_data['avatar']?>"  alt="Аватар">
                <div class="fields-box">
                    <div class="field" data-required="true">
                        <span class="field-name">Имя пользователя</span>
                        <span class="field-value" data-key="nickname"><?=$_GET['login']?><span id="user-tag" data-key="tag">#<?=$user_data['tag']?></span></span>
                    </div>
                    <div class="field" data-required="true">
                        <span class="field-name">Роль</span>
                        <span class="field-value" data-key="role"><?=$user_data['role']?></span>
                    </div>
                    <div class="field" data-required="true">
                        <span class="field-name">Электронная почта</span>
                        <span class="field-value" data-key="email"><?=$user_data['email']?></span>
                    </div>
                    <div class="field hidden" data-required="true">
                        <span class="field-name">Текущий пароль</span>
                        <span class="field-value"></span>
                    </div>
                    <div class="field hidden" data-required="true">
                        <span class="field-name hidden">Новый пароль</span>
                        <span class="field-value"></span>
                    </div>
                </div>
                <img src="/content/icons/edit.svg" data-for="main-settings" data-state="default" class="edit" alt="изменить">
            </div>
           <div class="header">
               <h2>ДОПОЛНИТЕЛЬНЫЕ НАСТРОЙКИ</h2>
               <img src="/content/icons/edit.svg" data-for="additional-settings" data-state="default" class="edit" alt="изменить">
           </div>
            <div class="p-setting-element" data-state="default" id="additional-settings">
                <div class="fields-box">
                    <div class="field">
                        <span class="field-name">Дополнительная почта</span>
                        <span class="field-value" data-key="spare_email"><?=$user_data['spare_email']?></span>
                    </div>
                    <div class="field">
                        <span class="field-name">Дата рождения</span>
                        <span class="field-value" data-key="birthday"><?=$user_data['birthday']?></span>
                    </div>
                    <div class="field">
                        <span class="field-name">Номер телефона</span>
                        <span class="field-value" data-key="phone_number"><?=$user_data['phone_number']?></span>
                    </div>
                </div>
            </div>
           <div class="header">
               <h2>Адрес доставки</h2>
               <img src="/content/icons/edit.svg" data-for="shipping-addresses" data-state="default" class="edit" alt="изменить">
           </div>
           <div class="p-setting-element" id="shipping-addresses">
                <div class="fields-box">
                    <div class="field" data-required="false">
                        <span class="field-name">Полное имя</span>
                        <span class="field-value" data-key="full_name"><?=$user_data['full_name']?></span>
                    </div>
                    <div class="field" data-required="true">
                        <span class="field-name">Адрес</span>
                        <span class="field-value" data-key="address"><?=$user_data['address']?></span>
                    </div>
                    <div class="field" data-required="true">
                        <span class="field-name">Номер квартиры</span>
                        <span class="field-value" data-key="apartment"><?=$user_data['apartment']?></span>
                    </div>
                    <div class="field" data-required="true">
                        <span class="field-name">Страна</span>
                        <span class="field-value" data-key="country"><?=$user_data['country']?></span>
                    </div>
                    <div class="field" data-required="true">
                        <span class="field-name">Город</span>
                        <span class="field-value" data-key="city"><?=$user_data['city']?></span>
                    </div>
                    <div class="field" data-required="true">
                        <span class="field-name">Почтовый индекс</span>
                        <span class="field-value" data-key="postcode"><?=$user_data['postcode']?></span>
                    </div>
                </div>
           </div>
       </section>
       <section id="r-sec">
           <div class="header">
               <h2>Двухфакторная аутентификация</h2>
           </div>
            <div class="p-setting-element" id="DFA">
                <span id="DFA-status">Двухфакторная аутентификация включена</span>
                <div id="DFA-buttons">
                    <button class="backup-codes">Резервные коды</button>
                    <button class="disable">Отключить</button>
                </div>
<!--                <span id="SMSAuth-status">Аутентификация по смс включена</span>-->
<!--                <span class="subSpan">Если у вас вдруг нет под рукой приложения аутентификации или резервных кодов, вы сможете получить код по смс.</span>-->
<!--                <button class="disable">Отключить</button>-->
            </div>
           <div class="header">
               <h2>Оплата</h2>
<!--               <img src="/content/icons/edit.svg" data-for="payment-settings" data-state="default" class="edit" alt="изменить">-->
           </div>
           <div class="p-setting-element" id="payment-settings">
               <div class="fields-box">
                   <div class="field" data-required="true">
                       <span class="field-name">Способ оплаты</span>
                       <span class="field-value">Банковская карта</span>
                   </div>
                   <div class="field" data-required="true">
                       <span class="field-name">Номер карты</span>
                       <span class="field-value">**** **** **** 2667</span>
                   </div>
                   <div class="field" data-required="true">
                       <span class="field-name">Срок службы</span>
                       <span class="field-value">12/22</span>
                   </div>
                   <div class="field hidden" data-required="true">
                       <span class="field-name">CVV</span>
                       <span class="field-value">***</span>
                   </div>
               </div>
           </div>
       </section>
   </section>
</div>
<? require_once "blocks/footer.php"; ?>
<script src="/js/menu.js"></script>
<script src="/js/profile-settings.js"></script>
</body>
</html>
