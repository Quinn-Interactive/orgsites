const thumbs = document.querySelectorAll('[data-video-modal]');
thumbs.forEach((thumb) => {
    const modal = document.querySelector(thumb.dataset.bsTarget);
    const body = modal.querySelector('[data-video-iframe]');
    const iframe = body.dataset.videoIframe;
    modal.addEventListener('show.bs.modal', () => {
        body.innerHTML = iframe;
    });
    modal.addEventListener('hide.bs.modal', () => {
        body.innerHTML = '';
    });
});
