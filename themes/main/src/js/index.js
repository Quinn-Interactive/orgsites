import 'bootstrap'; // needed for bootstrap interactions

// focus-point.js
if (document.querySelector('[data-focus-x]')) {
    import(/* webpackChunkName: "focuspoint-helper" */ './focuspoint-helper').then();
}
