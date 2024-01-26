// NO jQuery!
import debounce from 'lodash/debounce';

const header = document.querySelector('[data-scroll-hide]');

if (header) {
    const threshold = header.offsetHeight;
    let lastWindowScrollPos = window.scrollY;

    // detect scrolled page so we can add a droshadow to the nav
    const detectPageScroll = () => {
        const wScroll = window.scrollY;
        if (!header.classList.contains('-scrolling')) {
            if (wScroll == 0) {
                header.classList.add('-top');
                header.classList.remove('-scrolled');
            } else {
                header.classList.remove('-top');
                header.classList.add('-scrolled');
            }

            if (wScroll < threshold) {
                header.classList.remove('-hidden');
                header.classList.add('-visible');
            } else if (wScroll > lastWindowScrollPos) {
                header.classList.remove('-visible');
                header.classList.add('-hidden');
            } else if ((window.innerHeight + window.pageYOffset) >= document.body.offsetHeight) {
                // do nothing, since we're at the bottom.
            } else if (wScroll < lastWindowScrollPos) {
                header.classList.remove('-hidden');
                header.classList.add('-visible');
            }
        }
        lastWindowScrollPos = wScroll;
    };

    detectPageScroll();

    // eslint-disable-next-line
    const debounceDetectPageScroll = debounce(detectPageScroll, 100, 'immediate');

    window.addEventListener('scroll', detectPageScroll);
    window.addEventListener('resize', detectPageScroll);
}

