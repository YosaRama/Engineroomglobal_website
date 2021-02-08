var ic_hash = Math.random().toString(36).substr(2, 5);
//
var timeout_ajax = 30 * 1000;
var bulk_retry = 0;
var bulk_count = 0;
var wps_restore = '';
var wps_compress = '';
var wps_bulk_running = false;
//
var wps_compress_objects = [];
var wps_restore_objects = [];
var saving_settings = false;

jQuery(document).ready(function ($) {


    /**
     * Reset Stats
     */
    $('.ic-reset-stats').on('click', function (e) {
        e.preventDefault();
        show_stats_reset_popup();
        return false;
    });


    /**
     * Reset Cache
     */
    $('.ic-reset-cache').on('click', function (e) {
        e.preventDefault();
        show_cdn_reset_popup();
        return false;
    });


    /**
     * Checkbox Change Ajax
     * TODO: Maybe not required anymore?
     */
    $('.wp-ic-ajax-checkbox').on('click', function (e) {
        e.preventDefault();

        saving_settings = true;

        var parent = $(this).parent();
        var input = $('input', parent);
        var setting_name = $(input).data('setting_name');
        var value = $(input).data('setting_value');
        var checked = $(input).is(':checked');
        value = $(input).data('setting_value');

        if ($(input).is(':checked')) {
            $(input).removeAttr('checked');
            checked = false;
        } else {
            $(input).attr('checked', 'checked');
            checked = true;
        }


        $.post(ajaxurl, {action: 'wps_ic_settings_change', what: setting_name, value: value, checked: checked, checkbox: true}, function (response) {
            if (response.success) {
                // Nothing
                saving_settings = false;
            } else {
                alert('Oops! We weren\'t able to save your settings! :(');
            }
        });
    });


    $('.btn-purge-cdn').on('click', function (e) {
        return true;
        e.preventDefault();

        $.post(ajaxurl, {action: 'wps_ic_purge_cdn'}, function (response) {
            if (response.success) {
                // Nothing
                saving_settings = false;
            } else {
                alert('Oops! We weren\'t able to save your settings! :(');
            }
        });

        return false;
    });



    /**
     * Remote Restore Image Button - Single!!
     */
    $('.wps-ic-remote-restore').on('click', function (e) {
        e.preventDefault();

        wps_restore = 'true';
        trigger_speed = 1500;

        var button = $(this);
        var attachment_id = $(this).data('image_id');
        var select = $('input[name="wps_ic_restore_' + attachment_id + '"]').val();

        var parent = $('#wp-ic-image-actions-' + attachment_id);
        var loading = $('#wp-ic-image-loading-' + attachment_id);

        $(parent).hide();
        $(loading).show();

        wps_restore_objects.push(attachment_id);

        $.ajaxSetup({async: true, cache: false});
        $.post(ajaxurl, {action: 'wps_ic_restore', attachment_id: attachment_id, file: select, attachments: wps_restore_objects, hash: ic_hash}, function (response) {

            wps_ic_remote_restore_heartbeat();
            if (response.success == true) {
                trigger_speed = 5000;
                wps_compress = '';
            }

        });

    });


    $('.wps-ic-simple-exclude,.wps-ic-simple-include').on('click', function (e) {
        e.preventDefault();

        var button = $(this);
        var attachment_id = $(button).data('attachment_id');

        var parent = $('#wp-ic-image-actions-' + attachment_id);
        var loading = $('#wp-ic-image-loading-' + attachment_id);

        $(parent).hide();
        $(loading).show();

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {action: 'wps_ic_simple_exclude_image', attachment_id: attachment_id},
            success: function (response) {
                // Image data
                $('div#wp-ic-image-' + attachment_id).html(response.data.info);

                // Setup new actions
                $('div#wp-ic-image-actions-' + attachment_id).html(response.data.actions);

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


    $('.wps-ic-pro-exclude,.wps-ic-pro-include').on('click', function (e) {
        e.preventDefault();

        var button = $(this);
        var attachment_id = $(button).data('attachment_id');

        var parent = $('#wp-ic-image-actions-' + attachment_id);
        var loading = $('#wp-ic-image-loading-' + attachment_id);

        $(parent).hide();
        $(loading).show();

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {action: 'wps_ic_exclude_image', attachment_id: attachment_id},
            success: function (response) {
                // Image data
                $('div#wp-ic-image-' + attachment_id).html(response.data.info);

                // Setup new actions
                $('div#wp-ic-image-actions-' + attachment_id).html(response.data.actions);

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


    jQuery('.ic-credit-line').on('click', function (e) {
        e.preventDefault();

        Swal.fire({
            title: '',
            html: jQuery('#ic_no_credits_popup').html(),
            width: 900,
            showCloseButton: true,
            showCancelButton: false,
            showConfirmButton: false,
        });
    });

    jQuery('.ic-credit-line-additional').on('click', function (e) {
        e.preventDefault();

        Swal.fire({
            title: '',
            width: 900,
            html: jQuery('#ic_additional_credits_popup').html(),
            showCloseButton: true,
            showCancelButton: false,
            showConfirmButton: false,
        });
    });


});

window.onbeforeunload = function () {
    if (saving_settings) {
        return 'Request in progress....are you sure you want to continue?';
    }
};