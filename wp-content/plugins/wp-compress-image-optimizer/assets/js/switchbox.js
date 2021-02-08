jQuery(document).ready(function ($) {

    /**
     * Switch Box
     * @since 3.3.0
     */
    $('a', '.wp-ic-select-box').on('click', function (e) {
        e.preventDefault();

        var link = $(this);
        var li = $(this).parent();
        var ul = $(li).parent();
        var div = $(ul).parent();

        if ($(div).hasClass('disabled')) {
            return false;
        }

        $('li', ul).removeClass('current');
        $(link).parent().addClass('current');
    });


});