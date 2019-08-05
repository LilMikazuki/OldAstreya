// Инициализируем переменные и получаем формы для ввода
let loginInp = getInputByName('login'),
    passwordInp = getInputByName('password'),
    submit = document.querySelector("button.submit"),
    userData = document.querySelectorAll("#auth-data label input");

// Добавление события при клике на кнопку "Продолжить"
submit.addEventListener("click", function (e) {
    e.preventDefault(); // Отменяем действие по умолчанию
    if (checkLogin(loginInp) && checkPassword(passwordInp)) {
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
    return document.querySelector('#auth-data input[name="' + name + '"');
}

/**
 * Отправка данных на сервер
 */
function sendData() {
    // Асинхронный запрос на сервер
    (async () => {
        try {
            const rawResponse = await fetch('/php/auth.php', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
				// отправка данных на сервер в формате JSON
                body: JSON.stringify({'login':loginInp.value,'password':passwordInp.value})
            });
			// полчение ответа от сервера
            const content = await rawResponse.json();
            if (content === 'Successful') {
                window.location.href = '//astreya.ddns.net';
            }
            else {
                alert(content);
            }
        } catch (e) {
            throw new Error(e);
        }
    })();
}