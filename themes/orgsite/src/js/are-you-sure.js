const els = document.querySelectorAll('[data-are-you-sure]');
els.forEach((el) => {
    const message = el.dataset.areYouSure;
    if (message) {
        el.addEventListener('click', (e) => {
            if (el.href) {
                e.preventDefault();
                if (confirm(message) === true) {
                    document.location = el.href;
                }
            } else if (el.tagName == 'BUTTON' || el.tagName == 'INPUT') {
                const form = el.closest('form');
                if (form && form.checkValidity()) {
                    e.preventDefault();
                    if (confirm(message) === true) {
                        form.submit();
                    }
                }
            }
        });
    }
});
