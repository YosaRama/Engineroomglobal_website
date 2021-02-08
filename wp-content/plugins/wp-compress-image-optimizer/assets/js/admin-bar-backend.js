jQuery(document).ready(function ($) {

    function clear_Cache() {
        $('.wp-compress-bar-clear-cache>a').on('click', function (e) {
            e.preventDefault();

            var li = $('#wp-admin-bar-wp-compress');
            var old_html = $(li).html();
            $(li).html('<span class="wp-compress-admin-bar-icon"></span><span style="padding-left: 30px;">Purging cache...</span>');

            $.post(ajaxurl, {action: 'wps_ic_purge_cdn'}, function (response) {
                if (response.success) {
                    $(li).html(old_html);
                    clear_Cache();
                } else {

                }
            });

            return false;
        });
    }

    clear_Cache();

});