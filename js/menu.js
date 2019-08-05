let navPanel = document.getElementById('nav-panel'); // Навигационная панель (НП)
navPanel.style.display = 'block';
let navUL = document.querySelector('#nav-panel ul'); // Список с пунктами для навигации
let screenWidth = document.documentElement.clientWidth; // Текущая ширина окна браузера у пользователя

if (screenWidth <= 600 && navPanel.dataset.minimize === 'no') { minimize(); }
else if (navPanel.dataset.minimize === 'yes') { maximize(); }

// Свертывание и развертывание НП, при изменении размеров окна
window.onresize = () => {
    if (screenWidth <= 600 && navPanel.dataset.minimize === 'no') { minimize(); }
    else if (screenWidth > 600 && navPanel.dataset.minimize === 'yes') { maximize(); }
    screenWidth = document.documentElement.clientWidth;
};

/**
 * Уменьешение навигационной панели (НП)
 */
function minimize() {
    navPanel.dataset.minimize = 'yes'; // изменение статуса НП
    // Добавление класса всем доцерним элементам НП
    let li = navUL.children;
    for (let i = 0; i < li.length; i++) {
        li[i].classList.toggle('menu-element');
    }

    // Создание новых элементов и перещмещение старых
    let menuSvg = document.createElement('img');
    menuSvg.src = 'content/icons/menu.svg';
    menuSvg.alt = 'Меню';

    let menuOpenBtn = document.createElement('div');
    menuOpenBtn.classList.add('nav-element');
    menuOpenBtn.classList.add('show-menu-btn');
    menuOpenBtn.append(menuSvg);

    let collPan = document.createElement('div');
    collPan.classList.add('minimize-panel');
    collPan.append(navUL);

    navPanel.append(menuOpenBtn);
    navPanel.append(collPan);

    // Добавляем кнопке событие, которое срабатывает при клике, для развертывания меню
    menuOpenBtn.addEventListener("click", function() {
        let panel = this.nextElementSibling;
        if (panel.style.maxHeight){
            panel.style.maxHeight = null;
        } else {
            panel.style.maxHeight = panel.scrollHeight + "px";
        }
    });
}

/**
 * Восстановление нормального вида НП
 */
function maximize() {
    navPanel.dataset.minimize = 'no';
    navPanel.append(navUL);
    let li = navUL.children;
    for (let i = 0; i < li.length; i++) {
        li[i].classList.toggle('menu-element');
    }
    document.querySelector('#nav-panel .minimize-panel').remove();
    document.querySelector('#nav-panel .show-menu-btn').remove();
}