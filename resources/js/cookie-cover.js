'use strict';

import { CookieConsent } from './cookie-consent';

const DISPLAY_SLEEP_TIME = 500;

/**
 * Class for initializing the cookie covers on the current page.
 */
export default class CookieCover {
    /**
     *
     * @param {CookieConsent} instance
     */
    constructor(instance) {
        this._instance = instance;

        this._covers = document.querySelectorAll('.ddmcc');

        // Stop execution if there were no cookie covers found in html
        if (this._covers.length === 0) {
            return;
        }

        // Create
        this._covers.forEach((cover) => {
            // Don't bother to initialize any further if all cookie types have already been consented to
            if (this._instance.hasConsent(cover.dataset.classes)) {
                return;
            }

            const cover_button = cover.querySelector('#ddmcc-button-accept');

            // Stop initialization if the button isn't present
            if (cover_button === null) // TODO Find IE11-compatible equivalent to document.body.contains(...)
                return;

            cover_button.addEventListener('click', (event) => {
                event.preventDefault();

                this._instance.consent(cover.dataset.classes);

                this.hide(cover.id);
            });
        });
    }

    /**
     * Returns the first cookie cover with a given handle.
     *
     * @param {string} handle
     * @returns {Element} the node element
     */
    getCoverByHandle(handle) {
        return document.querySelector('.ddmcc#' + handle) ?? false;
    }

    show(handle) {
        let cover = this.getCoverByHandle(handle);

        if (cover) {
            cover.style.display = 'block';

            setTimeout(() => {
                cover.style.opacity = '1';
            }, 10);
        }
    }

    hide(handle) {
        let cover = this.getCoverByHandle(handle);

        if (cover) {
            cover.style.opacity = '0';

            setTimeout(() => {
                cover.style.display = 'none';
            }, DISPLAY_SLEEP_TIME);
        }
    }
}
