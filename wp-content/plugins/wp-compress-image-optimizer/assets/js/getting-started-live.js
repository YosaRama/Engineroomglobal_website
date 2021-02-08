jQuery(document).ready(function ($) {

    var swalFunc = function open_getting_started_popup() {
        Swal.fire({
            title: '',
            html: jQuery('.wps-ic-getting-started-live').html(),
            width: 850,
            position: 'center',
            customClass: 'wps-ic-getting-started-popup',
            showCloseButton: false,
            showCancelButton: false,
            showConfirmButton: false,
            allowOutsideClick: false,
            onOpen: function () {


            }
        });
    }

    swalFunc();


});