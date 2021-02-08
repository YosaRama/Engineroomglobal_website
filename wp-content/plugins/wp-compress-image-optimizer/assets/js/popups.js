function show_leave_popup() {

    var $ = jQuery.noConflict();

    Swal.fire({
        title: '',
        html: jQuery('#leave-popup').html(),
        width: 900,
        customClass: 'cdn-popup-container',
        showCloseButton: true,
        showCancelButton: false,
        showConfirmButton: false,
        onOpen: function () {

        }
    });

}

function show_cdn_popup() {

    var $ = jQuery.noConflict();

    Swal.fire({
        title: '',
        html: jQuery('#cdn-popup').html(),
        width: 900,
        customClass: 'cdn-popup-container',
        showCloseButton: true,
        showCancelButton: false,
        showConfirmButton: false,
        onOpen: function () {

            var inner = $('#cdn-popup-inner', '#swal2-content');
            $.post(ajaxurl, {action: 'check_cdn_status'}, function (response) {
                if (response.success) {
                    $(inner).html(response.data.html);
                    //swal.update();
                } else {
                    $(inner).html(response.data.html);
                    //swal.update();
                }
            });

        }
    });

}

function show_cdn_reset_popup() {

    var $ = jQuery.noConflict();

    Swal.fire({
        title: '',
        html: jQuery('#cdn-reset-popup').html(),
        width: 900,
        customClass: 'cdn-popup-container',
        showCloseButton: true,
        showCancelButton: false,
        showConfirmButton: false,
        onOpen: function () {

            var inner = $('#cdn-popup-inner', '#swal2-content');
            $.post(ajaxurl, {action: 'reset_cdn_cache'}, function (response) {
                if (response.success) {
                    $(inner).html(response.data.html);
                    //swal.update();
                } else {
                    $(inner).html(response.data.html);
                    //swal.update();
                }
            });

        }
    });

}

function show_stats_reset_popup() {

    var $ = jQuery.noConflict();

    Swal.fire({
        title: '',
        html: jQuery('#stats-reset-popup').html(),
        width: 900,
        customClass: 'cdn-popup-container',
        showCloseButton: true,
        showCancelButton: false,
        showConfirmButton: false,
        onOpen: function () {

            var inner = $('#cdn-popup-inner', '#swal2-content');
            $.post(ajaxurl, {action: 'reset_stats'}, function (response) {
                if (response.success) {
                    $(inner).html(response.data.html);
                    //swal.update();
                } else {
                    $(inner).html(response.data.html);
                    //swal.update();
                }
            });

        },
        onClose: function() {
            window.location.reload();
        }
    });

}