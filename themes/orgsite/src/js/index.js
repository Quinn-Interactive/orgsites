import  'bootstrap'; // needed for bootstrap interactions

// scroll-hide
if (document.querySelector('[data-scroll-hide]')) {
    import(/* webpackChunkName: "scroll-hide" */ './scroll-hide').then();
}

// alert
if (document.querySelector('[data-alert]')) {
    import(/* webpackChunkName: "alert" */ './alert').then();
}

// clipboard
if (document.querySelector('[data-clipboard]')) {
    import(/* webpackChunkName: "clipboard" */ './clipboard').then();
}

// focus-point.js
if (document.querySelector('[data-focus-x]')) {
    import(/* webpackChunkName: "focuspoint-helper" */ './focuspoint-helper').then();
}

// are-you-sure
if (document.querySelector('[data-are-you-sure]')) {
    import(/* webpackChunkName: "are-you-sure" */ './are-you-sure').then();
}

// video-modal.js
if (document.querySelector('[data-video-modal]')) {
    import(/* webpackChunkName: "video-modal" */ './video-modal').then();
}

// slider.js
if (document.querySelector('[data-slider]')) {
    import(/* webpackChunkName: "slider" */ './slider').then();
}

// lightbox.js
if (document.querySelector('[data-lightbox]')) {
    import(/* webpackChunkName: "lightbox" */ './lightbox').then();
}

