'use strict';

import { CookieConsent } from './cookie-consent';

const DISPLAY_SLEEP_TIME = 300;

/**
 * Class for initializing the cookie covers on the current page.
 */
export class CookieCover {
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

        });



        // for (let overlay in this._co_overlays) {
        //     if (Object.prototype.hasOwnProperty.call(this._co_overlays, overlay)) {
        //         console.log(overlay);
        //
        //         // Don't bother to initialize any further if all cookie types have already been consented to
        //         if (this._instance.hasConsent(overlay.dataset.types)) {
        //             return;
        //         }
        //
        //         console.log(overlay.htmlElement.querySelector('#ddmco-button-accept'));
        //
        //         overlay.htmlElement.querySelector('#ddmco-button-accept').addEventListener('click', (event) => {
        //             event.preventDefault();
        //
        //             this._instance.consent(overlay.cookieTypes);
        //
        //             this.hide(overlay.slug);
        //         });
        //     }
        // }
    }

    /**
     * Returns the first cookie cover with a given handle.
     *
     * @param {string} handle
     * @returns {Element} the node element
     */
    getCoverByHandle(handle) {
        return document.querySelector('.ddmcc#' + handle);
    }

    show(slug) {
        if (slug in this._covers) {
            let element = this._covers[slug].htmlElement;

            element.style.display = 'block';

            setTimeout(() => {
                element.style.opacity = '1';
            }, 10);
        }
    }

    hide(slug) {
        if (slug in this._covers) {
            let element = this._covers[slug].htmlElement;

            element.style.opacity = '0';

            setTimeout(() => {
                element.style.display = 'none';
            }, DISPLAY_SLEEP_TIME);
        }
    }
}
