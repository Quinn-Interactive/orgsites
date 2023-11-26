import htmlToElement from 'html-to-element';
import animateScrollTo from 'animated-scroll-to';
import Hammer from 'hammerjs';

const sliders = document.querySelectorAll('[data-slider]');
console.log({sliders});
const updateArrows = () => {
    sliders.forEach((slider) => {
        const wrapper = slider.querySelector('[data-slider-slides]');
        const slides = wrapper.children;
        const slideWidth = slides[0].offsetWidth;
        const prev = slider.querySelector('[data-slider-prev]');
        const next = slider.querySelector('[data-slider-next]');
        if (prev && next) {
            prev.hidden = null;
            next.hidden = null;

            if (wrapper.scrollLeft == 0) {
                prev.hidden = true;
            }
            if (wrapper.scrollLeft >= slides.length * slideWidth - wrapper.parentElement.offsetWidth) {
                next.hidden = true;
            }
        }
    });
};

const scrollSlides = (wrapper, x) => {
    const slides = wrapper.children;
    const slideWidth = slides[0].offsetWidth;
    const shifted = Math.round(wrapper.scrollLeft / slideWidth);
    const scroll = (shifted + x) * slideWidth;
    animateScrollTo([scroll, 0], {
        elementToScroll: wrapper,
    }).then(() => {
        updateArrows();
    });
};

sliders.forEach((slider) => {
    const slidesWrapper = slider.querySelector('[data-slider-slides]');
    slidesWrapper.dataset.sliderSlides = 0; //  index of currrent slide
    const prev = htmlToElement('<button class="slider__arrow -prev" data-slider-prev title="Previous"></button>');
    const next = htmlToElement('<button class="slider__arrow -next" data-slider-next title="Next"></button>');
    slider.prepend(prev);
    slider.prepend(next);

    prev.addEventListener('click', () => {
        scrollSlides(slidesWrapper, -1);
    });
    next.addEventListener('click', () => {
        scrollSlides(slidesWrapper, 1);
    });

    const hammertime = new Hammer(slidesWrapper);

    hammertime.on('swipeleft', () => {
        scrollSlides(slidesWrapper, 1);
    });
    hammertime.on('swiperight', () => {
        scrollSlides(slidesWrapper, -1);
    });
});

updateArrows();

