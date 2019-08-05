/**
 * Устанавливает значение Cookie
 * @param name Название Cookie
 * @param value Значение Cookie
 * @param options Настройки (path, expires, ...)
 */
function setCookie(name, value, options) {
    options = options || {};

    let expires = options.expires;
    if (typeof expires == "number" && expires) {
        let d = new Date();
        d.setTime(d.getTime() + expires * 1000);
        expires = options.expires = d;
    }
    if (expires && expires.toUTCString) {
        options.expires = expires.toUTCString();
    }
    value = encodeURIComponent(value);

    let updatedCookie = name + "=" + value;
    for (let propName in options) {
        updatedCookie += "; " + propName;
        let propValue = options[propName];
        if (propValue !== true) {
            updatedCookie += "=" + propValue;
        }
    }
    document.cookie = updatedCookie;
}

/**
 * Удаление Cookie
 * @param name Имя Cookie
 */
function deleteCookie(name) {
    setCookie(name, "", {
        expires: -1
    })
}