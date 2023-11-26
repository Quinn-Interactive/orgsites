import 'bootstrap'; // needed for bootstrap interactions

// scroll-hide
if (document.querySelector('[data-scroll-hide]')) {
    import(/* webpackChunkName: "scroll-hide" */ './scroll-hide').then();
}

// focus-point.js
if (document.querySelector('[data-focus-x]')) {
    import(/* webpackChunkName: "focuspoint-helper" */ './focuspoint-helper').then();
}

// video-modal.js
if (document.querySelector('[data-video-modal]')) {
    import(/* webpackChunkName: "video-modal" */ './video-modal').then();
}

// slider.js
if (document.querySelector('[data-slider]')) {
    import(/* webpackChunkName: "slider" */ './slider').then();
}