// https://github.com/third774/image-focus
// https://github.com/jonom/silverstripe-focuspoint
import { FocusedImage } from 'image-focus';

const focusOptions = {
    updateOnWindowResize: true,
    updateOnContainerResize: true,
};

const focusImages = document.querySelectorAll('[data-focus-x]');
for (let i = 0; i < focusImages.length; i++) { // eslint-disable-line no-plusplus
    // flip Y value
    const y = parseFloat(focusImages[i].dataset.focusY) * -1;
    focusImages[i].dataset.focusY = y;
    focusImages[i].setAttribute('data-focus-y', y);

    // ignore lazyload images until they are ready
    if (!focusImages[i].classList.contains('lazyload')) {
        const focusedImage = new FocusedImage(focusImages[i], focusOptions); // eslint-disable-line no-unused-vars, max-len
        focusImages[i].classList.add('focused');
    }
}

// process lazyloaded images
document.addEventListener('lazyloaded', (e) => {
    const img = e.target;
    if (img.hasAttribute('data-focus-x')) {
        const focusedImage = new FocusedImage(img, focusOptions); // eslint-disable-line no-unused-vars, max-len
        img.classList.add('focused');
        // console.log(img);
    }
});

// fire a resize just to be safe
if (typeof Event === 'function') {
    // modern browsers
    window.dispatchEvent(new Event('resize'));
} else {
    // for IE and other old browsers
    // causes deprecation warning on modern browsers
    const evt = window.document.createEvent('UIEvents');
    evt.initUIEvent('resize', true, false, window, 0);
    window.dispatchEvent(evt);
}
