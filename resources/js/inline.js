import { CookieConsent, CookieModal, CookieOverlay } from './cookie-notice';

let loadCookieNotice = () => {
    window.CookieConsent = new CookieConsent();
    window.CookieModal = new CookieModal(window.CookieConsent);
    window.CookieOverlay = new CookieOverlay(window.CookieConsent);
};

if (document.readyState !== "loading") loadCookieNotice();
else document.addEventListener("DOMContentLoaded", loadCookieNotice);
