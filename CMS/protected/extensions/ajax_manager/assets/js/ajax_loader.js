/**
 * Загрузка контента при прокрутке страницы
 *
 * Параметры (settings)
 *
 * param object объект класса paramManager
 * url string адрес для асинхронного запроса
 * selector string селектор контейнера контента
 * loader_class string класс лоадера
 * delta integer расстояние до конца страницы на которм срабатывает лоадер
 * page_key string имя параметра в котором передается номер страницы
 * tag_name string имя тега для обертки результата
 *
 * Структура xml ответа сервера
 *
 * <?xml version="1.0" encoding="windows-1251"?><root>
 * <total>общее количество записей</total>
 * <items>
 * <item><![CDATA[ html код элемента ]]></item>
 * <items>
 *
 */

var ajaxLoader = function (settings) {

    this.param = settings.param;

    this.url = settings.url;

    this.selector = settings.selector;

    this.loader_class = settings.loader_class || null;

    this.delta = settings.delta || 200;

    this.page_key = settings.page_key || 'page';

    this.tag_name = settings.tag_name || 'li';

    this.callback = settings.callback || null;

    // Номер подгруженной страницы

    this.num_pages = 0;

    // Количество загруженных элементов

    this.loaded = 0;

    // Общее количество элементов 

    this.total = -1; // -1 запрос не отправлен

    var self = this;

    this.ajax = new ajaxManager({ // Менеджер асинхронных запросов
        url: self.url,
        param: self.param,
        rtype: 'xml',
        callback: function (data) {
            self.removeLoader();
            self.loadData(data);
            self.constructor.processing = 0;
            self.num_pages += 1;
            $("body").trigger("content-updated");
        }

    });

// Инициализация

    var init = function () {

        var self = this;

        $(window).scroll(function () { // Навешиваем обработчик на объект window

            if (ajaxLoader.disable_scroll == 0) {
                var scrollTop = $(window).scrollTop();
                var doc_height = $(document).height();
                var window_height = $(window).height();

                if (scrollTop + window_height > doc_height - self.delta) { // Достижение конца страницы

                    self.doRequest(); // Отправка запроса

                }


            }

        });

        self.doRequest(); // Отправка запроса

    }

    init.apply(this);

}


/**
 *  Сброс счетчиков в начальное состояние
 */

ajaxLoader.prototype.reset = function () {

    this.num_pages = 0;

    this.loaded = 0;

    this.total = -1;

    this.cleanAll();

}

/**
 *  Удаление всех элементов
 */

ajaxLoader.prototype.cleanAll = function () {

    $(this.selector).empty();

}

/**
 * Утанавливаем лоадер
 */

ajaxLoader.prototype.setLoader = function () {

    if ($("." + this.loader_class).length == 0) {

        $(this.selector).after('<div class="' + this.loader_class + '"></div>');

    }

}

/**
 * Удаление лоадер
 */

ajaxLoader.prototype.removeLoader = function () {

    $("." + this.loader_class).remove();

}

/**
 * Вызов отправки запроса
 */

ajaxLoader.prototype.doRequest = function () {

    if (this.constructor.processing == 1) return; // Подгрузка уже запущена

    if (this.loaded == this.total) return; // Все данные уже загружены

    if ($(this.selector).length == 0) return; // Dom элемент не существует, данные загружать некуда

    this.constructor.processing = 1;

    var obj = this;

    obj.setLoader();

    this.param.set(this.page_key, obj.num_pages); // Устанавливаем номер страницы

    this.param.riseChange(); // Вызываем событие по которуму начнется подгрузка

}

/**
 * Загрузка данных в список
 */

ajaxLoader.prototype.loadData = function (data) {

    var obj = this;

    obj.total = parseInt($(data).find("total").text()); // Общее количество товаров

    $(data).find("item").each(function () {

        var html = $(this).text();

        $(obj.selector).append("<" + obj.tag_name + ">" + html + "</" + obj.tag_name + ">");

        obj.loaded += 1; // Увеличиваем счетчик загруженных элементов

    });

    if (this.callback) {
        this.callback();
    }

}

/**
 * Признак отключения подгрузки при скролле
 */

ajaxLoader.disable_scroll = 0;

/**
 * Признак выполнения запроса
 */

ajaxLoader.processing = 0;
   