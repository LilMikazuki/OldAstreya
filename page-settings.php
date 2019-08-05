<?php require_once "php/session_start.php"; require_once "php/check_auth.php";?>
<!DOCTYPE html>
<html lang="ru">
<? $title = 'Настрйоки страницы'; require_once "blocks/head.php"; ?>
<body>
<? require_once "blocks/main-nav-panel.php";
require_once "php/page/getPageInfo.php";
$project_data = getPageInfo($_SESSION['id'], '');?>
<section id="astreya-settings-page" class="ASTREYA--about-page">
    <nav>
        <ul id="page-nav" class="nav-list--settings">
            <li data-setting-section="1" class="navbar__li active" data-for="main-settings">Основное</li>
            <li data-setting-section="2" class="navbar__li" data-for="tiers-settings">Уровни</li>
            <li data-setting-section="3" class="navbar__li" data-for="goals-settings">Цели</li>
<!--            <li data-setting-section="4" class="navbar__li" data-for="">Оплата</li>-->
        </ul>
    </nav>
    <section id="main-settings" class="ASTREYA--about-page__settings main active">
        <form id="fields" method="post" name="page-settings-form" class="form--separator">
            <div class="form__separator">
                <div class="field">
                    <label>
                        <span class="field-name required">Название страницы</span>
                        <input name="page-name" class="form-input" value="<?=$project_data['name']?>" type="text" maxlength="30" minlength="2" placeholder="Название" autocomplete="off" data-timeout="0" required/>
                    </label>
                </div>

                <div class="field">
                    <label>
                        <span class="field-name">Чем вы занимаетесь?</span>
                        <input name="page-theme" class="form-input" value="<?=$project_data['theme']?>" type="text" maxlength="60" minlength="10" placeholder="Например: музыка, подкасты, живопись, кинематограф" autocomplete="off" data-timeout="0" required/>
                    </label>
                </div>

                <div class="field">
                    <label>
                        <span class="field-name">Описание страницы</span>
                        <textarea name="page-description" class="form-input" spellcheck="true" maxlength="600" minlength="100" placeholder="Добавьте описание" data-timeout="0" required><?=$project_data['description']?></textarea>
                    </label>
                </div>
            </div>

            <div class="form__separator">
                <div class="field">
                    <span class="field-name">
                        Аватар профиля
                        <span class="sub-info">Рекомендуемый размер 256x256 пикселей.</span>
                    </span>
                    <label>
                        <div class="p-avatar">
                            <img src="projects/<?=$project_data['name']?>/avatar.png" alt="Аватар" id="img-avatar">
                            <input type="file" id="file-avatar" name="page-application" accept="image/jpeg,image/png">
                        </div>
                    </label>
                </div>
                <div class="field">
                    <span class="field-name">
                        Обложка профиля
                        <span class="sub-info">Рекомендуемый минимальный размер 1600x500 пикселей.</span>
                    </span>
                    <label>
                        <div class="p-cover">
                            <img src="projects/<?=$project_data['name']?>/cover.png" alt="Обложка" id="img-cover">
                            <input type="file" id="file-cover" name="page-application" accept="image/jpeg,image/png">
                        </div>
                    </label>
                </div>
            </div>

            <div class="form__separator">
                <div class="field">
                    <span class="field-name">Кто видит количество моих подписчиков?</span>
                    <ul class="settings__ul">
                        <li>
                            <label class="radio">
                                <input type="radio" name="subs-radio" id="subs__all_users" checked/>
                                <i class="radio"></i>
                                <span class="li__main-span">
                                    Все пользователи
                                    <span class="li__sub-span">Все пользователи Astreya будут видеть количество ваших подписчиков.</span>
                                </span>
                            </label>
                        </li>
                        <li>
                            <label class="radio">
                                <input type="radio" name="subs-radio" id="subs__only_subs"/>
                                <i class="radio"></i>
                                <span class="li__main-span">
                                    Только мои подписчики
                                    <span class="li__sub-span">Только ваши подписчики будут видеть количество ваших подписчиков.</span>
                                </span>
                            </label>
                        </li>
                        <li>
                            <label class="radio">
                                <input type="radio" name="subs-radio" id="subs__only_me"/>
                                <i class="radio"></i>
                                <span class="li__main-span">
                                    Только я
                                    <span class="li__sub-span">Никто кроме вас не будет видеть количество ваших подписчиков.</span>
                                </span>
                            </label>
                        </li>
                    </ul>
                </div>

                <div class="field">
                    <span class="field-name">Кто видит мой доход за месяц?</span>
                    <ul class="settings__ul">
                        <li>
                            <label class="radio">
                                <input name="income-radio"type="radio" id="income__all_users" checked/>
                                <i class="radio"></i>
                                <span class="li__main-span">
                                    Все пользователи
                                    <span class="li__sub-span">Все пользователи Astreya будут видеть ваш ежемесячный доход.</span>
                                </span>
                            </label>
                        </li>
                        <li>
                            <label class="radio">
                                <input name="income-radio" type="radio" id="income__only_subs"/>
                                <i class="radio"></i>
                                <span class="li__main-span">
                                    Только мои подписчики
                                    <span class="li__sub-span">Только ваши подписчики будут видеть ваш ежемесячный доход.</span>
                                </span>
                            </label>
                        </li>
                        <li>
                            <label class="radio">
                                <input name="income-radio" type="radio" id="income__only_me"/>
                                <i class="radio"></i>
                                <span class="li__main-span">
                                    Только я
                                    <span class="li__sub-span">Никто кроме вас не будет видеть ваш ежемесячный доход.</span>
                                </span>
                            </label>
                        </li>
                    </ul>
                </div>
            </div>

            <button type="submit" id="save-main" class="pulse-button pulse">Сохранить</button>
        </form>
    </section>
    <section id="tiers-settings" class="ASTREYA--about-page__settings tiers">
        <?php require_once "php/page/show_tiers.php"; getTiers(); ?>
        <button id="add-tier" class="pulse-button pulse">Добавить уровень</button>
        <form id="create-tier" method="post" class="form--separator" name="page-tiers" onsubmit="return;">
            <div class="form__separator">
                <div class="field" data-key="name">
                    <label>
                        <span class="field-name required">Название уровня</span>
                        <input class="tier-input" name="tier-name" type="text" maxlength="50" minlength="2" autocomplete="off" data-timeout="0" required />
                    </label>
                </div>

                <div class="field" data-key="price">
                    <label>
                        <span class="field-name required">
                            Стоимость подписки
                            <span class="sub-info">Минимальная стоимость – 50 рублей</span>
                        </span>
                        <input class="tier-input" name="tier-price" type="number" max="999999" min="50" autocomplete="off" data-timeout="0" required />
                    </label>
                </div>


                <div class="field" data-key="description">
                    <label>
                        <span class="field-name">Описание уровня</span>
                        <textarea class="tier-input" name="tier-description" autocomplete="off" data-timeout="0" required ></textarea>
                    </label>
                </div>

                <div class="field" data-key="limit">
                    <label>
                        <span class="field-name">
                            Лимит на покупку
                            <span class="sub-info">Если лимит устанавливать не нужно, оставьте поле пустым</span>
                        </span>
                        <input class="tier-input" name="tier-limit" type="number" max="5000" min="0" autocomplete="off" data-timeout="0" />
                    </label>
                </div>

                <div class="field" data-key="shipping">
                    <span class="field-name">Просить указать адрес доставки?</span>
                    <ul class="settings__ul">
                        <li>
                            <label class="radio">
                                <input value="1"  name="shipping_radio" type="radio" id="no_ask"/>
                                <i class="radio"></i>
                                <span class="li__main-span">
                                    Да
                                    <span class="li__sub-span">Если предполагается физическое вознаграждение пользователей, отметьте этот пункт.</span>
                                </span>
                            </label>
                        </li>
                        <li>
                            <label class="radio">
                                <input value="0" name="shipping_radio" type="radio" id="yes_ask" checked/>
                                <i class="radio"></i>
                                <span class="li__main-span">
                                    Нет
                                    <span class="li__sub-span">Если не предполагается физическое вознаграждение пользователей, отметьте этот пункт.</span>
                                </span>
                            </label>
                        </li>
                    </ul>
                </div>

                <div class="field" data-key="shipping">
                    <span class="field-name">Тип подписки</span>
                    <ul class="settings__ul">
                        <li>
                            <label class="radio">
                                <input value="1"  name="subscription-type" type="radio" id="monthly" checked/>
                                <i class="radio"></i>
                                <span class="li__main-span">
                                    Ежемесячная
                                    <span class="li__sub-span">Средства списываются раз в месяц.</span>
                                </span>
                            </label>
                        </li>
                        <li>
                            <label class="radio">
                                <input value="2" name="subscription-type" type="radio" id="for-unit"/>
                                <i class="radio"></i>
                                <span class="li__main-span">
                                    За единицу законченной работы
                                    <span class="li__sub-span">Средства списываются при каждом добавлении контента.</span>
                                </span>
                            </label>
                        </li>
                    </ul>
                </div>


                <div class="field benefits" data-key="benefits">
                    <span class="field-name required">Перечислите преимущества этого уровня</span>
                    <input  class="benefit-input" name="benefit-name" type="text" maxlength="100" minlength="10" autocomplete="off" data-timeout="0"/>
                    <div id="add-benefit" class="add-more-benefit"></div>
                </div>
                <button type="submit" id="save-tier" class="pulse-button pulse">Сохранить</button>
            </div>
        </form>
    </section>
    <section id="goals-settings" class="ASTREYA--about-page__settings goals">
        <?php //require_once "php/page/show_tiers.php"; getTiers(); ?>
        <button id="add-goal" class="pulse-button pulse">Добавить цель</button>
        <br>
        <form id="create-goal" method="post" class="form--separator" name="page-goals" onsubmit="return;">
            <div class="form__separator">
                <div class="field" data-key="name">
                    <label>
                        <span class="field-name required">Название</span>
                        <input class="goal-input" name="goal-name" type="text" maxlength="50" minlength="2" autocomplete="off" data-timeout="0" required />
                    </label>
                </div>

                <div class="field" data-key="description">
                    <label>
                        <span class="field-name">Описание</span>
                        <textarea class="goal-input" name="goal-description" autocomplete="off" data-timeout="0"></textarea>
                    </label>
                </div>

                <div class="field" data-key="price">
                    <label>
                        <span class="field-name">Cумма</span>
                        <input class="goal-input" name="goal-price" type="number" max="10000000" min="50" autocomplete="off" data-timeout="0" required />
                    </label>
                </div>

                <button type="submit" id="save-goal" class="pulse-button pulse">Сохранить</button>
            </div>
        </form>
    </section>
</section>
<script src="js/menu.js"></script>
<script src="js/a-page-settings.js"></script>
</body>
</html>