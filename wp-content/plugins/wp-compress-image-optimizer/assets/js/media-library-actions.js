jQuery(document).ready(function($){

    var allowRefresh = true;

    /**
     * Media Library - Heartbeat
     */
    var heartbeat = function(){
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {action: 'wps_ic_media_library_heartbeat'},
            success: function(response) {
                $.each(response.data, function(index,value) {
                    var parent = $('.wps-ic-media-actions-' + index);
                    var loading = $('.wps-ic-image-loading-' + index);
                    $(parent).show();
                    $(loading).hide();
                    $('.wps-ic-media-actions-' + index).html(value);
                });
            }
        });
    };

    heartbeat();
    setInterval(heartbeat(), 8000);

    /**
     * Details Live
     */
    $('body').on('click', '.wps-ic-compress-details', function (e) {
        e.preventDefault();

        var button = $(this);
        var attachment_id = $(button).data('attachment_id');

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {action: 'wps_ic_compress_details', attachment_id: attachment_id},
            success: function (response) {

                //jQuery('.wps-ic-compress-details-popup-' + attachment_id).html(response.data.html);

                // Load Popup
                Swal.fire({
                    title: '',
                    html: response.data.html,
                    width: 900,
                    showCloseButton: true,
                    showCancelButton: false,
                    showConfirmButton: false,
                });
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(xhr.responseText);
                console.log(thrownError);
            }
        });

    });

    /**
     * Exclude Live
     */
    $('body').on('click', '.wps-ic-exclude-live', function (e) {

        e.preventDefault();

        var button = $(this);
        var attachment_id = $(button).data('attachment_id');
        var parent = $('.wps-ic-media-actions-' + attachment_id);
        var loading = $('.wps-ic-image-loading-' + attachment_id);

        $(parent).hide();
        $(loading).show();

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {action: 'wps_ic_exclude_live', attachment_id: attachment_id},
            success: function (response) {
                //heartbeat();
                // Image data
                $('.wps-ic-media-actions-' + attachment_id).html(response.data.html);
                $(parent).show();
                $(loading).hide();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(xhr.responseText);
                console.log(thrownError);
            }
        });

    });

    /**
     * Restore Live
     */
    $('body').on('click', '.wps-ic-restore-live', function (e) {

        e.preventDefault();

        var button = $(this);
        var attachment_id = $(button).data('attachment_id');
        var parent = $('.wps-ic-media-actions-' + attachment_id);
        var loading = $('.wps-ic-image-loading-' + attachment_id);

        $(parent).hide();
        $(loading).show();

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {action: 'wps_ic_restore_live', attachment_id: attachment_id},
            success: function (response) {
                heartbeat();
                // Image data
                // $('.wps-ic-media-actions-' + attachment_id).html(response.data);

                // Setup new actions
                //$('div.wp-ic-image-actions-' + attachment_id).html(response.data.actions);

                //$(parent).show();
                //$(loading).hide();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(xhr.responseText);
                console.log(thrownError);
            }
        });

    });

    /**
     * Compress Live
     */
    $('body').on('click', '.wps-ic-compress-live-no-credits', function (e) {
        e.preventDefault();

        allowRefresh = false;
        var button = $(this);
        var attachment_id = $(button).data('attachment_id');
        var parent = $('.wps-ic-media-actions-' + attachment_id);
        var loading = $('.wps-ic-image-loading-' + attachment_id);

        // Load Popup
        Swal.fire({
            title: '',
            html: $('#no-credits-popup').html(),
            width: 600,
            showCancelButton: false,
            showConfirmButton: false,
            confirmButtonText: 'Okay, I Understand',
            allowOutsideClick: true,
            customClass: {
                container: 'no-padding-popup-bottom-bg switch-legacy-popup',
            },
            onOpen: function () {
            }
        });

        return false;
    });

    /**
     * Compress Live
     */
    $('body').on('click', '.wps-ic-compress-live', function (e) {
        e.preventDefault();

        allowRefresh = false;
        var button = $(this);
        var attachment_id = $(button).data('attachment_id');
        var parent = $('.wps-ic-media-actions-' + attachment_id);
        var loading = $('.wps-ic-image-loading-' + attachment_id);

        $(parent).hide();
        $(loading).show();

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {action: 'wps_ic_compress_live', attachment_id: attachment_id},
            success: function (response) {
                heartbeat();
                // Image data
                //$('.wps-ic-media-actions-' + attachment_id).html(response.data);

                // Setup new actions
                //$('div.wp-ic-image-actions-' + attachment_id).html(response.data.actions);

                //$(parent).show();
                //$(loading).hide();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                allowRefresh = true;
                console.log(xhr.status);
                console.log(xhr.responseText);
                console.log(thrownError);
            }
        });

    });


});

window.onbeforeunload = function() {
    if (!allowRefresh) {
        return "Data will be lost if you leave the page, are you sure?";
    }
};