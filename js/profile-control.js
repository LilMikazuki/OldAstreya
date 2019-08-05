let sections = document.querySelectorAll('#profile #profile-r nav ul li'); // Список секций

/* Идентификация события при выборе определенной секции   */
for (let i = 0; i < sections.length; i++) {
    sections[i].addEventListener("click", function () {
        toggleSection(i, sections, 'active');
    });
}

/**
 * Изменение отображаемой секции
 *
 * @param index индекс выбранной секции
 * @param items список всех секций
 * @param className название класса, который необходимо переключить
 */
function toggleSection(index, items, className) {
    items.forEach(function (itm, i) {
        if (i === index) {
            itm.classList.add(className);
            document.getElementById(itm.dataset.for).classList.add(className);
        } else {
            itm.classList.remove(className);
            document.getElementById(itm.dataset.for).classList.remove(className);
        }
    });
}