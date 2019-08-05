let pageMenuItems = document.getElementById('page-nav').childNodes, // Элементы меню настреок
    addTierBtn = document.getElementById('add-tier'), // Кнопка добавления уровня
    addGoalBtn = document.getElementById('add-goal'), // Кнопка добавления цели
    saveTierBtn = document.getElementById('save-tier'), // Кнопка для сохранения уровня
    saveMainBtn = document.getElementById('save-main'), // Кнопка для сохранения уровня
    addBenefitBtn = document.getElementById('add-benefit'), // Кнопка добавления преищества
    tierForm = document.getElementById('create-tier'), // Форма создания уровня
    goalForm = document.getElementById('create-goal'), // Форма создания целт
    avatarLoadBtn = document.getElementById('file-avatar'), // Кнопка загрузки аватарки
    coverLoadBtn = document.getElementById('file-cover'); // Кнопка загрузки обложки

/* Добавление события каждому элементу меню настроек.
Изменение активного пункта меню. */
for (let i = 0; i < pageMenuItems.length; i++) {
    pageMenuItems[i].addEventListener('click', function () {
        let active = document.querySelector('#page-nav li.active');
        active.classList.remove('active');
        document.querySelector('#' + active.dataset.for).classList.remove('active');
        this.classList.add('active');
        document.querySelector('#' + this.dataset.for).classList.add('active');


    });
}
// Добавление событий для кнопок
avatarLoadBtn.addEventListener('change', function () {
    let files = avatarLoadBtn.files,
        formData = new FormData();

    formData.append('action', 'setAvatar');
    formData.append('avatar', files[0]);

    (async () => {
        try {
            const rawResponse = await fetch('/php/page/pageSettings.php', {
                method: 'POST',
                body: formData
            });
            const content = await rawResponse.json(); // получаем информацию, которую вернул сервер
            if (content['answer'] === 'successful') {
                let newScr = content['src'];
                document.getElementById('img-avatar').setAttribute('src', newScr + '?' + Math.random());
            }
            else {
                alert(content);
            }
        } catch (e) {
            throw new Error(e);
        }
    })();
});

coverLoadBtn.addEventListener('change', function () {
    let files = coverLoadBtn.files,
        formData = new FormData();

    formData.append('action', 'setCover');
    formData.append('cover', files[0]);

    (async () => {
        try {
            const rawResponse = await fetch('/php/page/pageSettings.php', {
                method: 'POST',
                body: formData
            });
            const content = await rawResponse.json(); // получаем информацию, которую вернул сервер
            if (content['answer'] === 'successful') {
                let newScr = content['src'];
                document.getElementById('img-cover').setAttribute('src', newScr + '?' + Math.random());
            }
            else {
                alert(content);
            }
        } catch (e) {
            throw new Error(e);
        }
    })();
});

saveMainBtn.addEventListener('click', function (e) {
    e.preventDefault();
    let files = coverLoadBtn.files,
        formData = new FormData();

    let inputs = document.querySelectorAll('.field .form-input');

    for (let i = 0; i < inputs.length; i++) {
        formData.append(inputs[i].getAttribute('name'), inputs[i].value);
    }

    formData.append('action', 'updateInfo');

    (async () => {
        try {
            const rawResponse = await fetch('/php/page/pageSettings.php', {
                method: 'POST',
                body: formData
            });
            const content = await rawResponse.json(); // получаем информацию, которую вернул сервер
            if (content === 'successful') {
                alert("Данные обновлены");
            }
        } catch (e) {
            throw new Error(e);
        }
    })();
});


addTierBtn.addEventListener('click', toggleShowCreateTier);
addGoalBtn.addEventListener('click', toggleShowCreateGoal);
addBenefitBtn.addEventListener('click', addBenefitField);
saveTierBtn.addEventListener('click', function (e) {
    e.preventDefault();
    createTier();
    addTierBtn.click();
});

/**
 * Вставка нового полня для описания преимуществ уровня
 */
function addBenefitField() {
    let field = document.querySelector('div.field.benefits input[name="benefit-name"]'),
        benefit = field.cloneNode(false);
    benefit.value = '';
    addBenefitBtn.parentNode.insertBefore(benefit, addBenefitBtn);
}

/**
 * Показать / скрыть форму для создания нового уровня
 */
function toggleShowCreateTier() {
    let display = tierForm.style.display;
    if (display === 'flex') {
       addTierBtn.textContent = 'Добавить уровень';
        tierForm.style.display = 'none';
    } else {
        addTierBtn.textContent = 'Отмена';
        tierForm.style.display = 'flex';
    }
}

function toggleShowCreateGoal() {
    let display = goalForm.style.display;
    if (display === 'flex') {
        addGoalBtn.textContent = 'Добавить уровень';
        goalForm.style.display = 'none';
    } else {
        addGoalBtn.textContent = 'Отмена';
        goalForm.style.display = 'flex';
    }
}



function createTier() {
    let inputs = document.querySelectorAll('#create-tier .tier-input'),
        shipping = document.querySelectorAll('#create-tier input[name="shipping_radio"]'),
        subsType = document.querySelectorAll('#create-tier input[name="subscription-type"]'),
        benefits = document.querySelectorAll('#create-tier input.benefit-input'),
        json_data = {};

    // Заполнение json_data
    for (let i = 0; i < inputs.length; i++) {
        let name = inputs[i].getAttribute('name');
        json_data[name] = inputs[i].value;
    }

    // Получение информации о доставке
    for (let i = 0; i < shipping.length; i++) {
        let cb = shipping[i];
        if (cb.checked) {
            shipping = shipping[i];
            break;
        }
    }

    // Получение выбранного типа подписки
    for (let i = 0; i < subsType.length; i++) {
        let cb = subsType[i];
        if (cb.checked) {
            subsType = subsType[i];
            break;
        }
    }

    json_data['shipping_ask'] = shipping.value;
    json_data['subType'] = subsType.value;

    let benefit_data = {};
    for (let i = 0; i < benefits.length; i++) {
        benefit_data[i+1] = benefits[i].value;
    }

    json_data['benefits'] = benefit_data;

    console.log(json_data);

    // асинхронный запрос на сервер
    (async () => {
        try {
            const rawResponse = await fetch('/php/page/create_tiers.php', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(json_data) // измененные данные
            });
            const content = await rawResponse.json(); // получение информации, которую вернул сервер
            //alert(content); // вывод ответа от сервера
            alert("Уровень добавлен");
        } catch (e) {
            throw new Error(e);
        }
    })();
}