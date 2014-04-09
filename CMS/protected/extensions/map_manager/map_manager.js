/**
 * Менеджер карты
 */

var map_manager = {

    // Объект карты

    map: false,

    // Загрузка карты

    load_map: function (map_id, width, height, zoom) {

        width = width || 500;
        height = height || 400;
        zoom = zoom || 10;

        $("#" + map_id).width(width).height(height);

        if (!this.map) {


            this.map = new ymaps.Map(map_id, {
                // Центр карты
                center: [54.37, 39.43],
                // Коэффициент масштабирования
                zoom: zoom
            });

            this.map.controls.add("mapTools")
                // Добавление кнопки изменения масштаба
                .add("zoomControl")
                // Добавление списка типов карты
                .add("typeSelector");


        }

    },

    // Определение координат

    locate: function (address_val, coords_sel) {

        address_val = address_val || false;

        coords_sel = coords_sel || false;

        if (!address_val) throw new Error('Не задан адрес для локации');

        if (!this.map) throw new Error('Карта не существует');

        var obj = this;

        var myGeocoder = ymaps.geocode(address_val);

        myGeocoder.then(
            function (res) {

                var coords = res.geoObjects.get(0).geometry.getCoordinates();

                //alert('Координаты объекта :' + coords);

                var point = res.geoObjects.get(0);

                obj.put_point(point);

                if (coords_sel) $(coords_sel).val(coords);
            },

            function (err) {
                alert('Ошибка определения координат');
            });

    },

    // Возвращает ymaps.GeoObject по координатам

    get_point: function (coords, ballon) {

        ballon = ballon || {};

        var coords_arr = coords.split(',');

        var c1 = parseFloat(coords_arr[0]);

        var c2 = parseFloat(coords_arr[1]);

        var myPlacemark = new ymaps.Placemark([c1, c2], ballon);

        return myPlacemark;

    },


    // Добавление точки на карту

    put_point: function (point, center) {

        center = center || true;

        if (!this.map) throw new Error('Карта не существует');

        // Добавление полученного элемента на карту

        this.map.geoObjects.add(point);

        // Центрирование карты на добавленном объекте
        if (center) {
            this.map.panTo(point.geometry.getCoordinates());
        }

    },

    // Добавление коллекции на карту

    put_collection: function (collection) {

        if (!this.map) throw new Error('Карта не существует');

        this.map.geoObjects.add(collection);

    },

    // Удаляет с карты все объекты

    reset_map: function () {

        if (!this.map) throw new Error('Карта не существует');

        this.map.geoObjects.each(function (obj) {

            this.map.geoObjects.remove(obj);

        }, this);

    }


}