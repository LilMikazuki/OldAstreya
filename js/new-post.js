let inputs = document.querySelectorAll(".form-input"),
    fileInput = document.querySelector("input[type='file']"),
    createPostBtn = document.querySelector("button[type='submit']");

createPostBtn.addEventListener("click", function () {
    let files = fileInput.files,
        formData = new FormData(),
        json_data = {};

    // Заполнение formData
    for (let i = 0; i < inputs.length; i++) {
        let name = inputs[i].getAttribute('name');
        formData.append(name, inputs[i].value);
    }

    for (let i = 0; i < files.length; i++) {
        formData.append(files[i].name, files[i]);
    }

    for (key of formData.keys()) {
        console.log(`${key}: ${formData.get(key)}`);
    }

    // Асинхронный запрос на сервер
    (async () => {
        try {
            const rawResponse = await fetch('/php/new-post.php', {
                method: 'POST',
                body: formData
            });
            const content = await rawResponse.json(); // получаем информацию, которую вернул сервер
            if (content === 'Successful') {
                alert(content);
            }
            else {
                alert(content);
            }
        } catch (e) {
            throw new Error(e);
        }
    })();
});

/**
 * Создание iFrame
 * @param link идентфиикатор видео с YouTube
 */
function createIFrame(link) {
    let ifrm = document.createElement("iframe");
    link = 'http://www.youtube.com/embed/' + link;
    ifrm.setAttribute("src", link);
    ifrm.style.width = "560px";
    ifrm.style.height = "315px";
    ifrm.style.frameborder = "0";
    ifrm.style.border = "none";
    document.body.appendChild(ifrm);
}

