'use strict';

import Cookies from 'js-cookie';

/**
 * Cookie consent class for handling cookie requests, changes and callbacks
 */
export class CookieConsent {
    /**
     * Creating the cookie consent instance for handling cookie requests, changes and callbacks.
     *
     * Available options:
     *      - prefix: change the prefix for the saved cookies
     *      - callbacks: object with arrays of functions, which are called when a class type has been consented to
     *
     * @param {Object} options
     */
    constructor(options = {}) {
        this._defaults = {
            prefix: 'ddm-cookie-consent',
            callbacks: {}
        };
        this.debug = (!process.env.NODE_ENV || process.env.NODE_ENV === 'development');

        this._options = Object.assign({}, this._defaults, options);

        // Add trailing dash if none exists
        if (!this._options.prefix.endsWith('-')) {
            this._options.prefix += '-';
        }
    }

    /**
     * Add a callback to a given cookie type
     *
     * @param {string} cookieType the cookie type
     * @param {function} callback the callback function to be called when the cookie type has been consented to
     */
    registerCallback(cookieType, callback) {
        let array = this._splitString(cookieType);

        array.forEach((cookieType) => {
            if (!Array.isArray(this._options.callbacks[cookieType])) {
                this._options.callbacks[cookieType] = [];
            }

            this._options.callbacks[cookieType].push(callback);
        });
    }

    /**
     * Remove a callback to given cookie type
     *
     * @param {string} cookieTypes the cookie type
     */
    unregisterCallback(cookieTypes) {
        let array = this._splitString(cookieTypes);

        array.forEach((cookieType) => {
            if (this._options.callbacks[cookieType]) {
                delete this._options.callbacks[cookieType];
            }
        });
    }

    _runCallback(cookieType) {
        if (this.hasConsent(cookieType) &&
            cookieType in this._options.callbacks &&
            Array.isArray(this._options.callbacks[cookieType])) {
            this._options.callbacks[cookieType].forEach((callback) => {
                if (typeof callback === 'function') {
                    callback();
                }
            });
        }
    }

    _runConsentedCallbacks() {
        for (let cookieType in this._options.callbacks) {
            if (Object.prototype.hasOwnProperty.call(this._options.callbacks, cookieType)) {
                this._runCallback(cookieType);
            }
        }
    }

    /**
     * Checks whether the cookie type have already been consented to or not.
     *
     * @param cookieTypes the cookie type to check for
     * @returns {boolean} whether the cookie type have been consented to
     */
    hasConsent(cookieTypes) {
        let array = this._splitString(cookieTypes);
        let consented = false;

        array.forEach((cookieType) => {
            let cookie_content = Cookies.get(this._options.prefix + cookieType);
            consented = (cookie_content === 'true' || cookie_content === true);
        });

        return consented;
    }

    /**
     * Consents to given cookie types.
     *
     * @param cookieType the cookie type to consent to
     */
    consent(cookieType) {
        this.setConsent(cookieType, true);
    }

    /**
     * Sets the consent for a range of cookie types.
     *
     * @param cookieTypes the cookie types to set
     * @param {boolean, string} value
     */
    setConsent(cookieTypes, value) {
        let array = this._splitString(cookieTypes);

        array.forEach((cookieType) => {
            Cookies.set(this._options.prefix + cookieType, (value === true || value === 'true'), {expires: 365});

            this._runCallback(cookieType);
        });
    }

    _splitString(str) {
        return str.split(',');
    }
}
