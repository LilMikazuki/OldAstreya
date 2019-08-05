// Инициализируем переменные и получаем формы для ввода
let loginInp = getInputByName('login'),
    emailInp = getInputByName('email'),
    passwordInp = getInputByName('password'),
    submit = document.querySelector("button.submit"),
    userData = document.querySelectorAll("#registration-data label input");

/* Добавление события, срабатывающего при изменении значений в полях для ввода,
проверяющего корректность введённых данных. */
for (let i = 0; i < userData.length; i++) {
    userData[i].addEventListener("change", function () {
        if (this.value.length > 0) {
            //let result = checkLogin(this);
            let result = (this.getAttribute('name') === "login") ? checkLogin(this) : (this.getAttribute('name') === 'email') ? checkMail(this) : checkPassword(this);
            if (result === false) {
                this.style.border = '1px solid #E35A5F';
                this.style.background = 'rgba(227,90,95, 0.2)';
            } else {
                this.style.border = '1px solid rgba(162,180,87,1)';
                this.style.background = 'rgba(162,180,87,0.2)';
            }
        } else {
            if (this.hasAttribute('style'))
                this.removeAttribute('style');
        }
    });
}

// Добавление события при клике на кнопку "Продолжить"
submit.addEventListener("click", function (e) {
    e.preventDefault(); // Отменяем действие по умолчанию
    if (checkLogin(loginInp) && checkMail(emailInp) && checkPassword(passwordInp)) {
        sendData();
    } else {
        for (let i = 0; i < userData.length; i++) {
            userData[i].style.border = '1px solid #E35A5F';
            userData[i].style.background = 'rgba(227,90,95, 0.2)';
        }
    }
});

/**
 * Проверка пароля
 *
 * @param login Значение, указанное пользователем в качестве логина
 * @returns {boolean} Реезультат проверки регулярным выражением
 */
function checkLogin(login) {
    let login_pattern = new RegExp("^[a-zA-Z][a-zA-Z0-9-_]{5,16}$");
    return login_pattern.test(login.value);
}

/**
 * Проверка пароля
 *
 * @param email Значение, указанное пользователем в качестве адреса
 * электронной почты
 * @returns {boolean} Реезультат проверки регулярным выражением
 */
function checkMail(email) {
    let email_pattern = new RegExp("^[-\\w.]+@([A-z0-9][-A-z0-9]+\\.)+[A-z]{2,4}$");
    return email_pattern.test(email.value);
}

/**
 * Проверка пароля
 *
 * @param password Значение, указанное пользователем в качестве пароля
 * @returns {boolean} Реезультат проверки регулярным выражением
 */
function checkPassword(password) {
    let password_pattern = new RegExp("(?=^.{8,25}$)((?=.*\\d)|(?=.*\\W+))(?![.\\n])(?=.*[A-Z])(?=.*[a-z]).*$");
    return password_pattern.test(password.value);
}

/**
 * Получение input по имени
 * @param name Имя input`a
 * @returns {Element} input с указанным именем
 */
function getInputByName(name) {
    return document.querySelector('#registration-data input[name="' + name + '"');
}

/**
 * Отправка данных на сервер
 */
function sendData() {
    // Асинхронный запрос на сервер
    (async () => {
        try {
            const rawResponse = await fetch('/php/registration.php', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({'nickname':loginInp.value,'email':emailInp.value,'password':passwordInp.value})
            });
            const content = await rawResponse.json(); // получаем информацию, которую вернул сервер
            if (content === 'Successful') {
                let regBody = document.getElementById('registration-data');
                regBody.innerHTML = '<p>На указанный вами адрес электронной почты было отправлено письмо, для подтверждения личности.</p>'
            }
            else {
                alert(content);
            }
        } catch (e) {
            throw new Error(e);
        }
    })();
}