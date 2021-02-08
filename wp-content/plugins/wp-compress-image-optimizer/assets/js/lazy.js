var lazyImages = [];
var pictureTag = [];
var active;
var activeRegular;
var img_count = 1;
var browserWidth;
var forceWidth = 0;
var jsDebug = 0;

var WPCgetParents = function (elem) {
    if (jsDebug) {
        console.log('parents func');
        console.log(elem);
    }
    // Set up a parent array
    var parents = [];

    // Push each parent element to the array
    for (; elem && elem !== document; elem = elem.parentNode) {
        if (elem.childElementCount > 1) {
            break;
        }
        else {
            if (jsDebug) {
                console.log('parents func element');
                console.log(elem);
            }
            if (elem.classList.contains('logo')) {
                return 'logo';
                break;
            }
            parents.push(elem);
        }
    }

    // Return our parent array
    return parents;

};

function load() {
    browserWidth = window.innerWidth;
    lazyImages = [].slice.call(document.querySelectorAll("img.wps-ic-live-cdn"));
    pictureTag = [].slice.call(document.querySelectorAll("picture.wps-ic-picture-tag"));
    elementorInvisible = [].slice.call(document.querySelectorAll("section.elementor-invisible"));
    active = false;
    activeRegular = false;
    lazyLoad();
    pictureLoad();
}

if (wpc_vars.js_debug == 'true') {
    jsDebug = 1;
    console.log('JS Debug is Enabled');
}

var parent_before = false;
var isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);

if (isSafari) {
    wpc_vars.webp_enabled = 'false';
    if (jsDebug) {
        console.log('Safari Disable WebP');
    }
}

if (jsDebug) {
    console.log('Safari: ' + isSafari);
}

function pictureLoad() {
    pictureTag.forEach(function (pictureImage) {

        imgWidth = 1;
        var children = pictureImage.children;
        var pictureParent = WPCgetParents(pictureImage.parentNode);

        var last = Object.keys(pictureParent)[pictureParent.length - 1];
        pictureParent = Object.values(pictureParent)[last];

        parent_style = window.getComputedStyle(pictureParent);
        var widthIsPercent = parent_style.width.indexOf("%") > -1;

        if (widthIsPercent) {
            pictureParent = pictureParent.parentNode;
            parent_style = window.getComputedStyle(pictureParent);
        }

        var widthIsPercent = parent_style.width.indexOf("%") > -1;
        if (widthIsPercent) {
            parent_width = 1;
        }
        else {
            parent_width = Math.round(parseInt(parent_style.width));
        }

        if ((parent_width !== 0 && typeof parent_width !== 'undefined')) {
            // We found a great image size, use it
            imgWidth = parent_width;
        }
        else {
            imgWidth = 1;
        }

        if (typeof imgWidth == 'undefined' || !imgWidth || imgWidth == 0 || isNaN(imgWidth)) {
            imgWidth = 1;
        }

        for (var i = 0; i < children.length; i++) {
            var srcset = children[i].srcset;
            var src = children[i].src;
            if (srcset) {

                newApiURL = children[i].srcset;
                newApiURL = newApiURL.replace(/w:(\d{1,5})/g, 'w:' + imgWidth);

                if (window.devicePixelRatio >= 2 && wpc_vars.retina_enabled == 'true') {
                    newApiURL = newApiURL.replace(/retina:false/g, 'retina:true');

                    if (jsDebug) {
                        console.log('Retina set to True');
                        console.log('DevicePixelRation ' + window.devicePixelRatio);
                    }

                }
                else {
                    newApiURL = newApiURL.replace(/retina:true/g, 'retina:false');

                    if (jsDebug) {
                        console.log('Retina set to False');
                        console.log('DevicePixelRation ' + window.devicePixelRatio);
                    }

                }

                if (wpc_vars.webp_enabled == 'true' && isSafari == false) {
                    newApiURL = newApiURL.replace(/webp:false/g, 'webp:true');

                    if (jsDebug) {
                        console.log('WebP set to True');
                    }

                }
                else {
                    newApiURL = newApiURL.replace(/webp:true/g, 'webp:false');

                    if (jsDebug) {
                        console.log('WebP set to False');
                    }

                }

                if (wpc_vars.exif_enabled == 'true') {
                    newApiURL = newApiURL.replace(/exif:false/g, 'exif:true');
                }
                else {
                    newApiURL = newApiURL.replace(/\/exif:true/g, '');
                    newApiURL = newApiURL.replace(/\/exif:false/g, '');
                }

                children[i].srcset = newApiURL;
            }
            if (src) {

                newApiURL = children[i].src;
                newApiURL = newApiURL.replace(/w:(\d{1,5})/g, 'w:' + imgWidth);

                if (window.devicePixelRatio >= 2 && wpc_vars.retina_enabled == 'true') {
                    newApiURL = newApiURL.replace(/retina:false/g, 'retina:true');

                    if (jsDebug) {
                        console.log('Retina set to True');
                        console.log('DevicePixelRation ' + window.devicePixelRatio);
                    }

                }
                else {
                    newApiURL = newApiURL.replace(/retina:true/g, 'retina:false');

                    if (jsDebug) {
                        console.log('Retina set to False');
                        console.log('DevicePixelRation ' + window.devicePixelRatio);
                    }

                }

                if (wpc_vars.webp_enabled == 'true' && isSafari == false) {
                    newApiURL = newApiURL.replace(/webp:false/g, 'webp:true');

                    if (jsDebug) {
                        console.log('WebP set to True');
                    }

                }
                else {
                    newApiURL = newApiURL.replace(/webp:true/g, 'webp:false');

                    if (jsDebug) {
                        console.log('WebP set to False');
                    }

                }

                if (wpc_vars.exif_enabled == 'true') {
                    newApiURL = newApiURL.replace(/exif:false/g, 'exif:true');
                }
                else {
                    newApiURL = newApiURL.replace(/\/exif:true/g, '');
                    newApiURL = newApiURL.replace(/\/exif:false/g, '');
                }

                children[i].src = newApiURL;
            }
        }


    });
}

function lazyLoad() {
    if (active === false) {
        active = true;

        elementorInvisible.forEach(function (elementorSection) {
            if ((elementorSection.getBoundingClientRect().top <= window.innerHeight && elementorSection.getBoundingClientRect().bottom >= 0) && getComputedStyle(elementorSection).display !== "none") {
                elementorSection.classList.remove('elementor-invisible');

                elementorInvisible = elementorInvisible.filter(function (section) {
                    return section !== elementorSection;
                });
            }
        });

        lazyImages.forEach(function (lazyImage) {

            if ((lazyImage.getBoundingClientRect().top <= window.innerHeight + 500 && lazyImage.getBoundingClientRect().bottom >= 0) && getComputedStyle(lazyImage).display !== "none") {

                //var a = performance.now();
                //console.log('Loading image ' + a);


                if (jsDebug) {
                    console.log('Image srcset');
                    console.log(lazyImage.srcset);
                    console.log('Image data srcset');
                    console.log(lazyImage.dataset.srcset);
                }

                imageExtension = '';
                imageFilename = '';

                if (typeof lazyImage.dataset.src !== 'undefined' && lazyImage.dataset.src != '') {

                    if (lazyImage.dataset.src.endsWith('url:https')) {
                        return;
                    }

                    imageFilename = lazyImage.dataset.src;
                    imageExtension = lazyImage.dataset.src.split('.').pop();
                }
                else if (typeof lazyImage.src !== 'undefined' && lazyImage.src != '') {
                    if (lazyImage.src.endsWith('url:https')) {
                        return;
                    }

                    imageFilename = lazyImage.src;
                    imageExtension = lazyImage.src.split('.').pop();
                }


                if (imageExtension !== '') {
                    if (imageExtension !== 'jpg' && imageExtension !== 'jpeg' && imageExtension !== 'gif' && imageExtension !== 'png' && imageExtension !== 'svg' && lazyImage.src.includes('svg+xml') == false && lazyImage.src.includes('placeholder.svg') == false) {
                        return;
                    }
                }

                if (wpc_vars.speed_test == '1') {
                    if (img_count >= 6) {
                        return;
                    }
                    else {
                        forceWidth = 320;
                    }

                    img_count++;
                }

                // Integrations
                masonry = lazyImage.closest(".masonry");

                if (jsDebug) {
                    console.log('lazyImage:');
                    console.log(lazyImage);
                }

                image_parent = WPCgetParents(lazyImage);
                if (image_parent == 'logo') {
                    newApiURL = lazyImage.dataset.src;
                    newApiURL = newApiURL.replace(/w:(\d{1,5})/g, 'w:1');
                    lazyImage.style.opacity = 0;
                    lazyImage.classList.add("ic-fade-in");
                    lazyImage.classList.remove("wps-ic-lazy-image");
                    lazyImage.style.opacity = null;
                    return;
                }

                imageStyle = window.getComputedStyle(lazyImage);
                ImageWidthPreloaded = Math.round(parseInt(imageStyle.width));

                if (jsDebug) {
                    console.log('ImageFilename:' + imageFilename.toLowerCase());
                    console.log('lazyImage parent:');
                    console.log(image_parent);
                    console.log(image_parent.length);
                    console.log(Object.keys(image_parent)[image_parent.length - 1]);
                    console.log('--lazyImage parent end--');
                }

                var last = Object.keys(image_parent)[image_parent.length - 1];
                image_parent = Object.values(image_parent)[last];

                parent_style = window.getComputedStyle(image_parent);
                var widthIsPercent = parent_style.width.indexOf("%") > -1;

                if (widthIsPercent) {
                    image_parent = image_parent.parentNode;
                    parent_style = window.getComputedStyle(image_parent);
                }

                var widthIsPercent = parent_style.width.indexOf("%") > -1;
                if (widthIsPercent) {
                    parent_width = 1;
                }
                else {
                    parent_width = Math.round(parseInt(parent_style.width));
                }

                imageWidth = ImageWidthPreloaded;

                imageWidthNatural = lazyImage.dataset.width;
                imageHeightNatural = lazyImage.dataset.height;

                imageIsLogo = false;

                imageClass = [].slice.call(lazyImage.classList);
                imageClass = imageClass.join(" ");
                imageIsLogoClass = imageClass.toLowerCase().includes("logo");
                imageIsLogoSrc = imageFilename.toLowerCase().includes("logo");

                if (imageIsLogoClass || imageIsLogoSrc) {
                    imageIsLogo = true;
                }

                if (jsDebug) {
                    console.log('Image logo: ' + imageIsLogo);
                }

                if (typeof imageIsLogo == 'undefined' || !imageIsLogo) {
                    imageIsLogo = false;

                    if (wpc_vars.adaptive_enabled == '1' || wpc_vars.adaptive_enabled == 'true') {
                        if (!imageWidth || imageWidth == 0 || typeof imageWidth == 'undefined') {

                            if (jsDebug) {
                                console.log('Image Width Preloaded ' + imageWidth);
                            }

                            // LazyLoad Things
                            image_parent_type = lazyImage.parentNode.nodeName.toLowerCase();

                            if (image_parent_type == 'a') {
                                image_parent = lazyImage.parentNode.parentElement;
                            }
                            else {
                                image_parent = lazyImage.parentNode;
                            }

                            parent_style = window.getComputedStyle(image_parent);


                            if (parent_style.width == 'auto') {
                                image_parent = image_parent.parentNode;
                                parent_style = window.getComputedStyle(image_parent);
                            }

                            parent_width = Math.round(parseInt(parent_style.width));
                            imgWidth = Math.round(parseInt(parent_style.width));

                            if (jsDebug) {
                                console.log('Image Width set to: ' + imgWidth);
                                console.log(image_parent);
                            }

                            if (imgWidth == parent_width) {
                                image_parent = image_parent.parentNode;
                                parent_style = window.getComputedStyle(image_parent);
                                parent_width = Math.round(parseInt(parent_style.width));
                            }

                            if (jsDebug) {
                                console.log('Parent set to #131: ' + image_parent);
                            }

                            if (typeof imgWidth == 'undefined' || !imgWidth || imgWidth == 0 || isNaN(imgWidth)) {
                                imgWidth = 1;
                            }

                        }
                        else {
                            imgWidth = Math.round(parseInt(imageWidth));

                            if (jsDebug) {
                                console.log('Image Width Predefined ' + imgWidth);
                            }

                            // PArent
                            image_parent_type = lazyImage.parentNode.nodeName.toLowerCase();

                            if (image_parent_type == 'a') {
                                image_parent = lazyImage.parentNode.parentElement;
                            }
                            else {
                                image_parent = lazyImage.parentNode;
                            }

                            parent_style = window.getComputedStyle(image_parent);
                            parent_width = Math.round(parseInt(parent_style.width));
                            parent_height = Math.round(parseInt(parent_style.height));

                            if (jsDebug) {
                                console.log('Image Width set to #158: ' + imgWidth);
                                console.log(image_parent);
                                console.log(parent_width);
                            }

                            if (isNaN(parent_width)) {
                                image_parent = image_parent.parentNode;
                                parent_style = window.getComputedStyle(image_parent);
                                parent_width = Math.round(parseInt(parent_style.width));
                                parent_height = Math.round(parseInt(parent_style.height));
                            }

                            if (imgWidth == parent_width) {
                                image_parent = image_parent.parentNode;
                                parent_style = window.getComputedStyle(image_parent);
                                parent_width = Math.round(parseInt(parent_style.width));
                                parent_height = Math.round(parseInt(parent_style.height));
                            }


                            if (isNaN(imgWidth) || isNaN(parent_width)) {
                                imgWidth = browserWidth;
                            }

                            if (imgWidth > browserWidth) {
                                imgWidth = browserWidth;
                            }

                        }
                    }
                    else {

                        imgWidth = Math.round(parseInt(window.getComputedStyle(lazyImage).width));

                        image_parent = lazyImage.parentNode;
                        parent_style = window.getComputedStyle(image_parent);
                        parent_width = Math.round(parseInt(parent_style.width));
                        parent_height = Math.round(parseInt(parent_style.height));
                    }
                }
                else {
                    // Image is a logo or something like a logo
                    if (wpc_vars.adaptive_enabled == '1' || wpc_vars.adaptive_enabled == 'true') {
                        imgWidth = 400;
                        image_parent = lazyImage.parentNode;
                        parent_style = window.getComputedStyle(image_parent);
                        parent_width = Math.round(parseInt(parent_style.width));
                        parent_height = Math.round(parseInt(parent_style.height));
                    }
                    else {
                        imgWidth = 1;
                        image_parent = lazyImage.parentNode;
                        parent_style = window.getComputedStyle(image_parent);
                        parent_width = Math.round(parseInt(parent_style.width));
                        parent_height = Math.round(parseInt(parent_style.height));
                    }
                }

                if (imgWidth > browserWidth) {
                    imgWidth = browserWidth;
                }

                if (typeof imgWidth == 'undefined' || !imgWidth || imgWidth == 0 || isNaN(imgWidth)) {
                    imgWidth = 1;
                }

                imageRatio = imageWidthNatural / imageHeightNatural;


                if (typeof parent_height == 'undefined' || !parent_height || parent_height == 0) {
                    parent_height = Math.round(parseInt(parent_style.height));
                }

                if (typeof parent_height == 'undefined' || !parent_height || parent_height == 0) {
                    parent_height = lazyImage.dataset.height;
                }

                if (imageRatio < 1) {
                    newWidth = (parent_height * imageRatio);
                    imgWidth = Math.round(newWidth);
                }


                if (typeof imgWidth == 'undefined' || imageIsLogo && (imgWidth < 200 || (!imgWidth || imgWidth == 0))) {
                    imgWidth = 200;
                }


                if (forceWidth > 0 && imgWidth > 320) {
                    imgWidth = forceWidth;
                }

                if (jsDebug) {
                    console.log('Image:');
                    console.log(lazyImage);
                    console.log('Image Width: ' + imgWidth);
                }

                if (typeof imgWidth == 'undefined' || !imgWidth || imgWidth == 0 || isNaN(imgWidth)) {
                    imgWidth = 1;
                }

                if (isNaN(imgWidth) || imgWidth <= 30) {
                    imgWidth = 1;
                }

                if (jsDebug) {
                    console.log('Image srcset');
                    console.log(lazyImage.srcset);
                    console.log('Image data srcset');
                    console.log(lazyImage.dataset.srcset);
                }

                if (typeof lazyImage.srcset !== 'undefined' && lazyImage.srcset != '') {
                    newApiURL = lazyImage.srcset;
                    if (jsDebug) {
                        console.log('Image has srcset');
                        console.log(lazyImage.srcset);
                        console.log(newApiURL);
                    }
                    if (window.devicePixelRatio >= 2 && wpc_vars.retina_enabled == 'true') {
                        newApiURL = newApiURL.replace(/retina:false/g, 'retina:true');

                        if (jsDebug) {
                            console.log('Retina set to True');
                            console.log('DevicePixelRation ' + window.devicePixelRatio);
                        }

                    }
                    else {
                        newApiURL = newApiURL.replace(/retina:true/g, 'retina:false');

                        if (jsDebug) {
                            console.log('Retina set to False');
                            console.log('DevicePixelRation ' + window.devicePixelRatio);
                        }
                    }

                    if (wpc_vars.webp_enabled == 'true' && isSafari == false) {
                        newApiURL = newApiURL.replace(/webp:false/g, 'webp:true');

                        if (jsDebug) {
                            console.log('WebP set to True');
                        }

                    }
                    else {
                        newApiURL = newApiURL.replace(/webp:true/g, 'webp:false');

                        if (jsDebug) {
                            console.log('WebP set to False');
                        }

                    }

                    if (wpc_vars.exif_enabled == 'true') {
                        newApiURL = newApiURL.replace(/exif:false/g, 'exif:true');
                    }
                    else {
                        newApiURL = newApiURL.replace(/\/exif:true/g, '');
                        newApiURL = newApiURL.replace(/\/exif:false/g, '');
                    }
                    newApiURL = newApiURL.replace(/w:(\d{1,5})/g, 'w:' + imgWidth);
                    lazyImage.srcset = newApiURL;
                }
                else if (typeof lazyImage.dataset.srcset !== 'undefined' && lazyImage.dataset.srcset != '') {
                    newApiURL = lazyImage.dataset.srcset;
                    if (jsDebug) {
                        console.log('Image does not have srcset');
                        console.log(newApiURL);
                    }
                    if (window.devicePixelRatio >= 2 && wpc_vars.retina_enabled == 'true') {
                        newApiURL = newApiURL.replace(/retina:false/g, 'retina:true');

                        if (jsDebug) {
                            console.log('Retina set to True');
                            console.log('DevicePixelRation ' + window.devicePixelRatio);
                        }

                    }
                    else {
                        newApiURL = newApiURL.replace(/retina:true/g, 'retina:false');

                        if (jsDebug) {
                            console.log('Retina set to False');
                            console.log('DevicePixelRation ' + window.devicePixelRatio);
                        }
                    }

                    if (wpc_vars.webp_enabled == 'true' && isSafari == false) {
                        newApiURL = newApiURL.replace(/webp:false/g, 'webp:true');

                        if (jsDebug) {
                            console.log('WebP set to True');
                        }

                    }
                    else {
                        newApiURL = newApiURL.replace(/webp:true/g, 'webp:false');

                        if (jsDebug) {
                            console.log('WebP set to False');
                        }

                    }

                    if (wpc_vars.exif_enabled == 'true') {
                        newApiURL = newApiURL.replace(/exif:false/g, 'exif:true');
                    }
                    else {
                        newApiURL = newApiURL.replace(/\/exif:true/g, '');
                        newApiURL = newApiURL.replace(/\/exif:false/g, '');
                    }

                    newApiURL = newApiURL.replace(/w:(\d{1,5})/g, 'w:' + imgWidth);
                    lazyImage.dataset.srcset = newApiURL;
                }

                if (typeof lazyImage.dataset.src !== 'undefined' && lazyImage.dataset.src != '') {
                    newApiURL = lazyImage.dataset.src;
                    newApiURL = newApiURL.replace(/w:(\d{1,5})/g, 'w:' + imgWidth);

                    if (window.devicePixelRatio >= 2 && wpc_vars.retina_enabled == 'true') {
                        newApiURL = newApiURL.replace(/retina:false/g, 'retina:true');

                        if (jsDebug) {
                            console.log('Retina set to True');
                            console.log('DevicePixelRation ' + window.devicePixelRatio);
                        }

                    }
                    else {
                        newApiURL = newApiURL.replace(/retina:true/g, 'retina:false');

                        if (jsDebug) {
                            console.log('Retina set to False');
                            console.log('DevicePixelRation ' + window.devicePixelRatio);
                        }

                    }

                    if (wpc_vars.webp_enabled == 'true' && isSafari == false) {
                        newApiURL = newApiURL.replace(/webp:false/g, 'webp:true');

                        if (jsDebug) {
                            console.log('WebP set to True');
                        }

                    }
                    else {
                        newApiURL = newApiURL.replace(/webp:true/g, 'webp:false');

                        if (jsDebug) {
                            console.log('WebP set to False');
                        }

                    }

                    if (wpc_vars.exif_enabled == 'true') {
                        newApiURL = newApiURL.replace(/exif:false/g, 'exif:true');
                    }
                    else {
                        newApiURL = newApiURL.replace(/\/exif:true/g, '');
                        newApiURL = newApiURL.replace(/\/exif:false/g, '');
                    }

                    lazyImage.src = newApiURL;
                    if (typeof lazyImage.dataset.srcset !== 'undefined' && lazyImage.dataset.src != '') {
                        lazyImage.srcset = lazyImage.dataset.srcset;
                    }
                }
                else if (typeof lazyImage.src !== 'undefined' && lazyImage.src != '') {
                    newApiURL = lazyImage.src;
                    newApiURL = newApiURL.replace(/w:(\d{1,5})/g, 'w:' + imgWidth);

                    if (window.devicePixelRatio >= 2 && wpc_vars.retina_enabled == 'true') {
                        newApiURL = newApiURL.replace(/retina:false/g, 'retina:true');

                        if (jsDebug) {
                            console.log('Retina set to True');
                            console.log('DevicePixelRation ' + window.devicePixelRatio);
                        }

                    }
                    else {
                        newApiURL = newApiURL.replace(/retina:true/g, 'retina:false');

                        if (jsDebug) {
                            console.log('Retina set to False');
                            console.log('DevicePixelRation ' + window.devicePixelRatio);
                        }

                    }

                    if (wpc_vars.webp_enabled == 'true' && isSafari == false) {
                        newApiURL = newApiURL.replace(/webp:false/g, 'webp:true');

                        if (jsDebug) {
                            console.log('WebP set to True');
                        }

                    }
                    else {
                        newApiURL = newApiURL.replace(/webp:true/g, 'webp:false');

                        if (jsDebug) {
                            console.log('WebP set to False');
                        }

                    }

                    if (wpc_vars.exif_enabled == 'true') {
                        newApiURL = newApiURL.replace(/exif:false/g, 'exif:true');
                    }
                    else {
                        newApiURL = newApiURL.replace(/\/exif:true/g, '');
                        newApiURL = newApiURL.replace(/\/exif:false/g, '');
                    }

                    lazyImage.src = newApiURL;
                    if (typeof lazyImage.dataset.srcset !== 'undefined' && lazyImage.dataset.src != '') {
                        lazyImage.srcset = lazyImage.dataset.srcset;
                    }
                }

                lazyImage.style.opacity = 0;
                lazyImage.classList.add("ic-fade-in");
                lazyImage.classList.remove("wps-ic-lazy-image");
                lazyImage.style.opacity = null;

                lazyImages = lazyImages.filter(function (image) {
                    return image !== lazyImage;
                });

            }
        });

        active = false;
    }
}

window.addEventListener("resize", lazyLoad);
window.addEventListener("orientationchange", lazyLoad);
document.addEventListener("scroll", lazyLoad);
document.addEventListener("DOMContentLoaded", load);
if ('undefined' !== typeof jQuery) {
    jQuery(document).on('elementor/popup/show', function () {
        load();
    });
}