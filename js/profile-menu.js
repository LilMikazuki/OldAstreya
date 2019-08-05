let menu = document.querySelector('#nav-panel ul li ul.profile-menu'); // меню профиля
// Показывает меню профиля при наведении на аватарку
menu.parentNode.addEventListener('mouseover', function () {
    menu.hidden = false; // показать меню
});

// Скрывает меню при клике на любой другой элемент
document.querySelector('body').addEventListener('click', function () {
    menu.hidden = true; // скрыть меню
});