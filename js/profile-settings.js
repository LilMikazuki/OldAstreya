let editBtns = document.querySelectorAll('#p-settings img.edit'),
    tag = document.getElementById('user-tag'),
    nickname = tag.parentNode.childNodes[0].textContent,
    dataOld = {}, // объект для записи изменяемых данных
    dataNew = {}, // объект для записи измененных данных
    tagClone = tag.cloneNode(true);

for (let i = 0; i < editBtns.length; i++) {
    editBtns[i].addEventListener("click", function () {
        transform(editBtns[i].dataset.for, editBtns[i].dataset.state);
        // смена состояния и иконки
        if (this.dataset.state === 'default') {
            this.src = '/content/icons/save.svg';
            this.dataset.state = 'active';
        } else if (this.dataset.state === 'active') {
            this.src = '/content/icons/edit.svg';
            this.dataset.state = 'default';
        }
    });
}

/**
 * Подготовка данных к редактированию
 *
 * @param section редактируемая секция
 * @param state состояние (default - не редактируется, active - редактируется)
 */
function transform(section, state) {
    let fields = document.querySelectorAll('#p-settings #' + section + ' .field-value');
    // Замена span`ов на input`ы
    if (state === 'default') {
        getOldData(section);
        (section === 'main-settings') ? tag.remove() : false; // удаляет тег
        for (let i = 0; i < fields.length; i++) {
            let parent = fields[i].parentNode,
                input = document.createElement('input');
            (fields[i].dataset.key) ? input.dataset.key = fields[i].dataset.key : false;
            input.classList.add('field-value');
            input.value = fields[i].textContent;
            parent.replaceChild(input, fields[i]);
            (parent.classList.contains('hidden')) ? replaceClass(parent, 'shown', 'hidden') : false; // показываем некоторые поля
            (parent.dataset.required) ? parent.children[0].classList.add('required') : false; // добавляет класс, указывающий на обязательность заполнения
        }
    }
    // Замена input`ов на span`ы
    else if (state === 'active') {
        for (let i = 0; i < fields.length; i++) {
            let parent = fields[i].parentNode,
                span = document.createElement('span');
            (fields[i].dataset.key) ? span.dataset.key = fields[i].dataset.key : false;
            span.classList.add('field-value');
            span.textContent = fields[i].value;
            parent.replaceChild(span, fields[i]);
            tag = document.getElementById('user-tag');
            (section === 'main-settings' && i === 0) ? span.appendChild(tagClone) : false; // возвращает тег
            (parent.classList.contains('shown')) ? replaceClass(parent, 'hidden', 'shown') : false; // скрываем некоторые поля
            (parent.dataset.required) ? parent.children[0].classList.remove('required') : false; // удаляет класс, указывающий на обязательность заполнения
        }
        getNewData(section);
    }
}

/**
 * Смена класса у элемента
 *
 * @param element объект, у которого будет изменен класс
 * @param newClass название нового класса
 * @param oldClass название класса, который надо заменить
 */
function replaceClass(element, newClass, oldClass) {
    newClass = newClass || undefined;
    oldClass = oldClass || undefined;

    element.classList.remove(oldClass);
    element.classList.add(newClass);
}

/**
 * Получение данных из выбранной для редактирования секции настроек
 * @param section выбранная для настроек секция
 */
function getOldData(section) {
     let fields = document.querySelectorAll('#' + section + ' div.field > span.field-value'),
         key, value;

    for (let i = 0; i < fields.length; i++) {
        if (fields[i].hasAttribute('data-key')) {
            key = fields[i].dataset.key;
            value = (key !== 'nickname') ? fields[i].textContent : tag.parentNode.childNodes[0].textContent;
            dataOld[key] = value;
        }
    }
}

/**
 * Получение данных из измененной секции настроек
 * @param section выбранная для настроек секция
 */
function getNewData(section) {
    let fields = document.querySelectorAll('#' + section + ' div.field > span.field-value'),
    key, value;

    for (let i = 0; i < fields.length; i++) {
        if (fields[i].hasAttribute('data-key')) {
            key = fields[i].dataset.key;
            value = (key !== 'nickname') ? fields[i].textContent : tag.parentNode.childNodes[0].textContent;
            dataNew[key] = value;
            dataNew['section'] = section;
        }
    }

    sendCurrentUserData();
}

/**
 * Запрос к серверу на изменение данных
 */
function sendCurrentUserData() {
    // если данные до и после редактирования отличаются...
    if (JSON.stringify(dataOld) !== JSON.stringify(dataNew)) {
        // удаление из новых данных неизмененные поля
        for (let key in dataNew) {
            (dataNew[key] === dataOld[key]) ? delete dataNew[key] : false;
        }

        //if (dataNew.length < 1) { return false; }

        // асинхронный запрос на сервер
        (async () => {
            try {
                const rawResponse = await fetch('/php/profile/updateProfileData.php', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(dataNew) // измененные данные
                });
                const content = await rawResponse.json(); // получение информации, которую вернул сервер
                alert(content); // вывод ответа от сервера
            } catch (e) {
                throw new Error(e);
            }
        })();
    }
}