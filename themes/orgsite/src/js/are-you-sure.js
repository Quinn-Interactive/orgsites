const els = document.querySelectorAll('[data-are-you-sure]');
els.forEach((el) => {
    const message = el.dataset.areYouSure;
    if (message) {
        el.addEventListener('click', (e) => {
            e.preventDefault();
            if (confirm(message) === true) {
                // console.log(el.href);
                document.location = el.href;
            }
        });
    }
});
