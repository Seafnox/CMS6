/**
 * Менеджер параметров
 */

var paramManager = function () {

    this.event_name = 'change'; // Имя события на изменение

    this.params = {}; // Хранит параметры

}

/**
 * Установка значения параметра
 */

paramManager.prototype.set = function (key, value) {

    this.params[key] = value;

    return this;

}

/**
 * Получение значения параметра
 */

paramManager.prototype.get = function (key) {

    if (!this.params[key]) return false;

    return this.params[key];

}

/**
 * Удаление параметра
 */

paramManager.prototype.unset = function (key) {

    delete this.params[key];

    return this;

}


/**
 * Загрузка параметров из формы
 */

paramManager.prototype.setFromForm = function (formWrap) {

    var qs = formWrap.serialize();

    this.params = $.deparam(qs);

    return this;

}


/**
 * Загрузка параметров из строки
 */

paramManager.prototype.setFromString = function (qs) {

    this.params = $.deparam(qs);

    return this;

}


/**
 * Загрузка параметров из строки запроса
 */

paramManager.prototype.setFromQueryString = function () {

    if (window.history.pushState) {

        this.params = $.deparam.querystring();

    }
    else { // Для IE

        this.params = $.deparam(location.hash);

    }

    return this;

}


/**
 * Установка значений всех параметров
 */

paramManager.prototype.setAll = function (params) {

    this.params = params;

    return this;

}

/**
 * Получение всех параметров
 */

paramManager.prototype.getAll = function (key) {

    return this.params;

}


/**
 * Сброс всех параметров
 */

paramManager.prototype.resetAll = function () {

    this.params = {};

    return this;

}


/**
 * Проверяет наличие параметра
 */

paramManager.prototype.has = function (key) {

    return (typeop(this.params.key) != 'undefined') ? true : false;

}


/**
 * Обработка изменений состояния объекта
 */

paramManager.prototype.riseChange = function () {

    $(this).trigger(this.event_name);

    return this;

}


/**
 * Установка строки запроса
 */

paramManager.prototype.setQueryString = function () {

    if (window.history.pushState) { // Обновляем историю

        window.history.pushState(this.params, 'Title', "?" + $.param(this.params))

    }
    else { // Для IE

        location.hash = $.param(this.params);

    }

    return this;

}


