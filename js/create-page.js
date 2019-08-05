let submit = document.querySelector("button[type='submit']");

submit.addEventListener('click', function () {
   let inputs = document.querySelectorAll('#page-reg-data form .form-input'),
       adult = document.querySelectorAll('#page-reg-data form input[name="adult-radio"]'),
       json_data = {};

    // Заполнение json_data
   for (let i = 0; i < inputs.length; i++) {
       let name = inputs[i].getAttribute('name');
       json_data[name] = inputs[i].value;
   }

    // Получение информации о создании контента 18+
    for (let i = 0; i < adult.length; i++) {
        let cb = adult[i];
        if (cb.checked) {
            adult = adult[i];
            break;
        }
    }
    json_data['adult'] = adult.value;

    console.log(json_data);

    // асинхронный запрос на сервер
    (async () => {
        try {
            const rawResponse = await fetch('/php/page/create-page.php', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(json_data) // измененные данные
            });
            const content = await rawResponse.json(); // получение информации, которую вернул сервер
            alert(content); // вывод ответа от сервера
        } catch (e) {
            throw new Error(e);
        }
    })();
});