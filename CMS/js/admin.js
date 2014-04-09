$(document).ready(function(){

    // Фиксирует панель с кнопками действий в форме редактирования элемента

    $(window).on('scroll', function() {

        var elem = $('.fixed-form-actions');

        if(elem.length == 0)
            return;

        var top = elem.data('top');

        if(!top) {
            var top =elem.offset().top;
            elem.data('top', top);
        }

        var margin_bottom = elem.css('margin-bottom');

        var width = elem.css('width');

        var height = $(window).scrollTop() + $(window).height();

        if(top > height ) {
            elem.css(
                {
                    'position': 'fixed',
                    'bottom': 0,
                    'width': width,
                    'margin-bottom': 0,
                    'opacity': 0.8
                });
        } else  {
            elem.css({
                'position': 'static',
                'margin-bottom': margin_bottom,
                'opacity': 1
            });
        }

    }).trigger('scroll');

});