'use strict';

import { CookieConsent } from './cookie-consent';

const DISPLAY_SLEEP_TIME = 300;

/**
 * Class for initializing the cookie modal and its actions.
 */
export class CookieModal {
    /**
     * Initializes the cookie modal if it is found on the page.
     *
     * @param {CookieConsent} instance the CookieConsent instance
     */
    constructor(instance) {
        this._instance = instance;

        // As there should only be one cookie modal we query only the first in the DOM
        this._modal = document.querySelector('.ddmcm');

        // Query all cookie class checkboxes and stop initialization if there are none
        this._modal_checks = this._modal.querySelectorAll('.ddmcm-classes input[type=\"checkbox\"]');
        this._modal_unchecked_checks = () => this._modal.querySelectorAll('.ddmcm-classes input[type=\"checkbox\"]:not(:checked)');

        if (this._modal_checks.length === 0) {
            return;
        }

        // Check all previously checked checkboxes, except the ones which are checked already
        this._modal_unchecked_checks().forEach((check) => {
            check.checked = this._instance.hasConsent(check.name);
        });

        // Query the two buttons and stop initialization if they aren't present
        this._modal_button_all = this._modal.querySelector('#ddmcm-button-all');
        this._modal_button_selected = this._modal.querySelector('#ddmcm-button-selected');

        if (!document.body.contains(this._modal_button_all) && !document.body.contains(this._modal_button_selected)) {
            return;
        }

        this._modal_button_all.addEventListener('click', (event) => {
            event.preventDefault();

            this.checkAll();

            this._finalize();
        });

        this._modal_button_selected.addEventListener('click', (event) => {
            event.preventDefault();

            this._finalize();
        });

        // Show the cookie notice if it hasn't already been interacted with
        if (!this._instance.hasConsent('showed')) {
            this.show();
        }
    }

    /**
     * Shows the cookie modal.
     */
    show() {
        this._modal.style.display = 'block';
        setTimeout(() => {
            this._modal.style.opacity = '1';
        }, 10);
    }

    /**
     * Hides the cookie modal.
     */
    hide() {
        this._modal.style.opacity = '0';
        setTimeout(() => {
            this._modal.style.display = 'none';
        }, DISPLAY_SLEEP_TIME);
    }

    /**
     * Checks all the cookie class checkboxes.
     */
    checkAll() {
        this._modal_unchecked_checks().forEach((check) => check.click());
    }

    /**
     * Consents for all checked cookie class checkboxes.
     * @private
     */
    _pushSettings() {
        this._modal_checks.forEach((check) => {
            if (check.checked) {
                this._instance.consent(check.name);
            }
        });

        this._instance.consent('showed');
    }

    /**
     * Consents for all checked cookie class checkboxes and hides the cookie modal.
     * @private
     */
    _finalize() {
        this._pushSettings();

        setTimeout(this.hide.bind(this), DISPLAY_SLEEP_TIME);
    }
}
