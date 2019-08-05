let commentInputs = document.querySelectorAll('textarea.input--comment'),
    commentsBtn = document.querySelectorAll('.post ul .li--comment'),
    likesBtn = document.querySelectorAll('.post ul .li--like'),
    navbar = document.querySelectorAll('.navbar--page .navbar__ul .navbar__li'),
    sections = document.querySelectorAll('.section--page'),
    sendPostBtn = document.getElementById('send-post-btn'),
    textareaPost = document.getElementById('wall-post-content'),
    subscribeBtn = document.querySelectorAll('button.join');

// отправка комментария
for (let i = 0; i < commentInputs.length; i++) {
    commentInputs[i].addEventListener('keydown', function(e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            this.value = '';
            let comment_data = {
                'content': this.value,
                'postId': this.dataset.postId
            };
            // Асинхронный запрос на сервер
            (async () => {
                try {
                    const rawResponse = await fetch('/php/addComment.php', {
                        method: 'POST',
                        body: JSON.stringify(comment_data)
                    });
                    const content = await rawResponse.json(); // получаем информацию, которую вернул сервер
                    document.querySelector('.section--comments').innerHTML += content;
                    document.querySelector('span.comments-count').textContent = parseInt(document.querySelector('span.comments-count').textContent) + 1;
                } catch (e) {
                    throw new Error(e);
                }
            })();
        }
    });
}

/**
 * Показать/скрыть комментарии
 */
for (let j = 0; j < commentsBtn.length; j++) {
    commentsBtn[j].addEventListener('click', function () {
        if (this.dataset.shown === 'false') {
            this.dataset.shown = 'true';
            let comments = document.querySelector('.post[data-post-id="' + this.parentNode.dataset.postId + '"] .section--comments');
            comments.style.display = "none";
        } else if (this.dataset.shown === 'true') {
            this.dataset.shown = 'false';
            let comments = document.querySelector('.post[data-post-id="' + this.parentNode.dataset.postId + '"] .section--comments');
            comments.style.display = "flex";
        }
    });
}

for (let j = 0; j < likesBtn.length; j++) {
    likesBtn[j].addEventListener('click', function () {
        let like = {'postId': this.parentNode.dataset.postId };
        if (this.hasAttribute('liked')) {
            this.removeAttribute('liked');
            this.children[0].src = '/content/icons/social/like.svg';
            this.children[1].textContent = parseInt(this.children[1].textContent) - 1;
        } else {
            this.setAttribute('liked', '');
            this.children[0].src = '/content/icons/social/is_like.svg';
            this.children[1].textContent = parseInt(this.children[1].textContent) + 1;
        }
        (async () => {
            try {
                await fetch('/php/setLike.php', {
                    method: 'POST',
                    body: JSON.stringify(like)
                });
            } catch (e) {
                throw new Error(e);
            }
        })();
    });
}

// изначальное скрытие
for (let j = 0; j < commentsBtn.length; j++) {
    commentsBtn[j].click();
}

for (let i = 0; i < navbar.length; i++) {
    navbar[i].addEventListener('click', function () {
        for (let i = 0; i < navbar.length; i++) {
            (navbar[i].classList.contains('active')) ? navbar[i].classList.remove('active') : false;
        }
        this.classList.add('active');
        for (let i = 0; i < sections.length; i++) {
            (sections[i].classList.contains(this.dataset.for)) ? sections[i].classList.add('active') : (sections[i].classList.contains('active')) ? sections[i].classList.remove('active') : false;
        }
    });
}

sendPostBtn.addEventListener('click', function () {
    let proj = {
        'prj': parseInt(project),
        'content': textareaPost.value
    };
        (async () => {
            try {
                const resp =await fetch('/php/page/sendWallPost.php', {
                    method: 'POST',
                    body: JSON.stringify(proj)
                });
                let content = await resp.json();
                alert(content);
            } catch (e) {
                throw new Error(e);
            }
        })();
});

for (let i = 0; i < subscribeBtn.length; i++) {
    subscribeBtn[i].addEventListener('click', function () {
        let data = {
            'prj': parseInt(project),
            'tier': this.dataset.tier,
            'type': 1
        };
        (async () => {
            try {
                const resp = await fetch('/php/page/subscribe.php', {
                    method: 'POST',
                    body: JSON.stringify(data)
                });
                let content = await resp.json();
                if (content === 'successful') {
                    subscribeBtn[i].textContent = "Вы подписаны";
                    subscribeBtn[i].setAttribute('disabled', 'disabled');
                }
            } catch (e) {
                throw new Error(e);
            }
        })();
    });
}