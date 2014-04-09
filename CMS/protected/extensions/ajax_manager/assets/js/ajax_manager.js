/**
 * Менеджер асинхронных запросов
 *
 * Параметры (settings)
 *
 * url string адрес для асинхронного запроса
 * param object объект класса paramManager
 * type string тип запроса (POST, GET), по умолчанию GET
 * callback function функция обрабатывающая ответ сервера
 * rtype string тип ответа (xml, json, script, html)
 *
 */


var ajaxManager = function (settings) {

    this.xhr = null; // Объет XmlHttpRequest

    settings = settings || {};

    // Проверка наличия обязательных параметров

    if (!settings.url || settings.url.length == 0) throw new Error("Не задан параметр url");

    if (!settings.param) throw new Error("Не задан объект параметров param");

    // Значения по умолчанию

    settings.type = settings.type || 'GET';

    settings.callback = settings.callback || function () {
    };

    settings.rtype = settings.rtype || 'html';

    this.settings = settings;

    // Слушаем изменение объекта параметров

    var self = this;

    $(this.settings.param).on(this.settings.param.event_name, function (event) {
        self.sendRequest();
        event.stopPropagation();
    });


}

/**
 * Отправка запроса серверу
 */

ajaxManager.prototype.sendRequest = function () {

    if (this.xhr != null) this.xhr.abort();

    if (this.settings.type == 'GET') {

        this.xhr = $.get(this.settings.url, this.settings.param.getAll(), this.settings.callback, this.settings.rtype);

    }
    else {

        this.xhr = $.post(this.settings.url, this.settings.param.getAll(), this.settings.callback, this.settings.rtype);

    }


}   