var carSlideItem = '#car-slide .item img';
var carSlideImgActive = '#car-slide .item.active img';
var carSlideAreaActive = '#car-slide .item.active area';
var s_view_extension = '.png';

$(document).ready(function (e) {
    $('.car-select-option').click(function (e) {
        var glue = '/';
        var $s_car_image = $(this).children();
        var s_car = $s_car_image.attr('data-car');
        var $s_view_images = $(carSlideItem);
        $.each($s_view_images, function (index, s_view_image) {
            $s_view_image = $(s_view_image);
            var s_view = $s_view_image.attr('data-view');
            var new_src = s_car + "-" + s_view + s_view_extension;
            var old_src = $s_view_image.prop('src');
            var string_parts = old_src.split(glue);
            var string_target = string_parts.length - 1;
            string_parts[string_target] = string_parts[string_target].replace(string_parts[string_target], new_src);
            $s_view_image.prop('src', string_parts.join(glue));
        });

        $('html, body').animate({
            scrollTop: $(".breadcrumb").offset().top
        }, 100);
    });

    $(carSlideImgActive).maphilight();
});