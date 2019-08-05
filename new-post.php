<? require_once "php/session_start.php"; ?>
<!DOCTYPE html>
<html lang="ru">
<? $title = 'Добавить запись'; require_once "blocks/head.php"; ?>
<body>
<? require_once "blocks/main-nav-panel.php"; ?>
<section class="content create-new-post">
    <h1 class="title">Создание нового поста</h1>
    <form id="new-post-form" method="post" class="form--new-page form--separator" name="new-page-form" enctype="multipart/form-data" onsubmit="return false;">
        <div class="form__separator">
            <div class="field">
                <label>
                    <span class="field-name">Заголовок</span>
                    <input class="form-input" name="post-title" type="text" maxlength="120" minlength="1" autocomplete="off" required/>
                </label>
            </div>

            <div class="field">
                <label>
                    <span class="field-name">Содержание поста</span>
                    <textarea class="form-input" name="post-content" maxlength="3000"></textarea>
                </label>
            </div>

            <div class="field">
                <label>
                   <span class="field-name">
                        Ссылка на видео
                        <span class="sub-info">Вы можете загрузить видео с YouTube. Подробнее <a href="content/documents/how-upload-with-youtube.html">тут</a>.</span>
                   </span>
                   <input class="form-input" id="v-link" name="post-videoLink" type="text" maxlength="50" minlength="1" autocomplete="off"/>
                </label>
            </div>

            <div class="field">
                <label>
                    <span class="field-name">Для кого доступен пост</span>
                    <select name="for-tier" id="select-for-tier" class="select--new-post form-input">
                        <option value="for-all">Для всех</option>
                    </select>
                </label>
            </div>

            <div class="field">
                <label>
                    <span class="field-name">
                        Приложение к посту
                        <span class="sub-info">Подробнее о правилах приложений вы можете прочитать <a href="/content/documents/application-rules.html">тут</a>.</span>
                    </span>
                    <input type="file" id="file-applications" name="page-application" accept="image/jpeg,image/png,image/gif,video/mp4,video/ogg,audio/mpeg3,audio/ogg,application/pdf,application/zip,application/x-rar-compressed,application/gzip,application/x-7z-compressed,application/msword,text/plain,application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint" multiple>
                    <div class="div--file-cover" id="file-cover">

                    </div>
                </label>
            </div>
        </div>
        <button type="submit" class="pulse-button pulse">Сохранить</button>
    </form>
</section>
<script src="/js/menu.js"></script>
<script src="/js/new-post.js"></script>
</body>
</html>