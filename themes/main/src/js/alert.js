import Cookies from 'js-cookie';

require('dom-slider');
const {
    slideUp,
    slideDown
} = window.domSlider;

const alerts = document.querySelectorAll('[data-alert]');
const cookieKey = 'site-alerts';
const layout = document.querySelector('main.main');
const alertlist = document.querySelector('[data-alert-list]');

const updateLayout = () => {
    if (layout && alertlist) {
        const height = alertlist.offsetHeight;
        layout.style.setProperty('--alert-height', `${height}px`);
    }
};

const showAlert = (el) => {
    slideDown({
        element: el,
        slideSpeed: 250,
        visibleDisplayValue: 'block',
    }).then(() => {
        el.removeAttribute('hidden');
        updateLayout();
    });
};

const hideAlert = (el) => {
    const height = alertlist.offsetHeight - el.offsetHeight;
    layout.style.setProperty('--alert-height', `${height}px`);
    slideUp({
        element: el,
        slideSpeed: 250,
    }).then(() => {
        el.setAttribute('hidden', true);
        updateLayout();
    });
};

alerts.forEach((el) => {
    const alertData = JSON.parse(el.dataset.alert);
    const {
        id,
        notify,
        updated,
        sessionId,
    } = alertData;
    const closers = el.querySelectorAll('[data-alert-close]');
    const alertsStore = Cookies.get(cookieKey) ? JSON.parse(Cookies.get(cookieKey)) : {};

    // add in our alert to the alertsStore if we haven't saved it yet
    if (!(id in alertsStore)) {
        alertsStore[alertData.id] = alertData;
        alertData.closed = false;
    }

    const savedAlert = alertsStore[id];

    // show based on notify and cookie
    if (notify === 'always') {
        // always show (never close)
        alertData.closed = false;
    } else if (savedAlert.updated !== updated) {
        // if the updated date is changed, re-show
        alertData.closed = false;
    } else if (notify === 'session' && (savedAlert.closed !== true || sessionId !== savedAlert.sessionId)) {
        // if this is a session alert, and either this isn't closed, or is a different session, show it
        alertData.closed = false;
    } else if (notify === 'once' && savedAlert.closed !== true) {
        alertData.closed = false;
    } else {
        // otherwise, it is closed
        alertData.closed = true;
    }

    // show it if it is not closed
    if (!alertData.closed) {
        showAlert(el);
    }
    // console.log({notify, savedAlert, alertData});

    // return false;

    // update alert in cookie and set it to expire in a year
    alertsStore[id] = alertData;
    Cookies.set(cookieKey, JSON.stringify(alertsStore), { expires: 365 });

    // close on click and remember that we closed it
    closers.forEach((close) => {
        close.addEventListener('click', (e) => {
            console.log({close, e});
            e.preventDefault();
            const savedAlerts = JSON.parse(Cookies.get(cookieKey));
            savedAlerts[id].closed = true;
            Cookies.set(cookieKey, JSON.stringify(savedAlerts), { expires: 365 });
            hideAlert(el);
        });    
    });

    window.addEventListener('resize', updateLayout);
});
