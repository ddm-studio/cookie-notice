import { CookieConsent } from './cookie-consent';
import { CookieModal } from './cookie-modal';
import { CookieCover } from './cookie-cover';

window.CookieConsent = new CookieConsent();
window.CookieModal = new CookieModal(window.CookieConsent);
window.CookieCover = new CookieCover(window.CookieConsent);
