// Fit to Screen Start
(function (w) {
    var dpr = ((w.devicePixelRatio === undefined) ? 1 : w.devicePixelRatio);
    var window_width = window.innerWidth;

    document.cookie = 'ic_window_resolution=' + window_width + '; path=/';
    document.cookie = 'ic_pixel_ratio=' + dpr + '; path=/';

    console.log('WP Compress DPR ' + dpr);
    console.log('WP Compress Window Width ' + window_width);

})(window);
// Fit to Screen End
