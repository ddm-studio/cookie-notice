'use strict';

import Cookies from 'js-cookie';

/**
 * Class for handling cookie requests, changes and callbacks
 */
export default class CookieConsent {
    /**
     * Creates the instance for handling cookie requests, changes and callbacks.
     *
     * Available options:
     *      - prefix: change the prefix for the saved cookies (WIP)
     *      - callbacks: object with arrays of functions, which are called when a cookie class has been consented to
     *
     * @param {Object} options
     */
    constructor(options = {}) {
        this._defaults = {
            // prefix: 'ddm-cookie-consent', TODO: Find a way to set prefix and let antlers tag know about it
            callbacks: {}
        };
        // this.debug = (!process.env.NODE_ENV || process.env.NODE_ENV === 'development');

        this._options = Object.assign({}, this._defaults, options);

        this._options.prefix = 'ddm-cookie-consent';

        // Add trailing dash if none exists
        if (!this._options.prefix.endsWith('-')) {
            this._options.prefix += '-';
        }

        this.cookieModal = null;
        this.cookieCover = null;
    }

    /**
     * Adds a callback function to a cookie class or a list of cookie classes.
     *
     * @param {string} cookieClasses the cookie classes
     * @param {function} callback the callback function to be called when the cookie classes have been consented to
     */
    registerCallback(cookieClasses, callback) {
        this._runSplitList(cookieClasses, (cookieClass) => {
            // Create callback array if it doesn't exist already
            if (!Array.isArray(this._options.callbacks[cookieClass])) {
                this._options.callbacks[cookieClass] = [];
            }

            this._options.callbacks[cookieClass].push(callback);
        });
    }

    /**
     * Removes the callbacks added to a cookie class or a list of cookie classes.
     *
     * @param {string} cookieClasses the cookie classes
     */
    unregisterCallback(cookieClasses) {
        this._runSplitList(cookieClasses, (cookieClass) => {
            // Deletes the callback entry if it exists
            if (this._options.callbacks[cookieClass]) {
                delete this._options.callbacks[cookieClass];
            }
        });
    }

    /**
     * Runs the callback function of a cookie class if it has been consented to.
     *
     * @param {string} cookieClass the cookie classes
     */
    runCallback(cookieClass) {
        // TODO: Prevention of running callbacks multiple times
        if (this.hasConsent(cookieClass)) {
            // check whether the cookie class has callback functions
            if (cookieClass in this._options.callbacks) {
                this._options.callbacks[cookieClass].forEach((callback) => {
                    if (typeof callback === 'function') {
                        callback();
                    }
                });
            }
        }
    }

    /**
     * Runs all the callback functions which cookie classes have been consented to.
     */
    runCallbacks() {
        for (let cookieClass in this._options.callbacks) {
            if (this._options.callbacks.hasOwnProperty(cookieClass)) {
                this.runCallback(cookieClass);
            }
        }
    }

    /**
     * Checks whether the cookie class or cookie classes have already been consented to.
     *
     * @param cookieClasses the cookie classes to check for
     * @returns {boolean} whether the cookie classes have been consented to
     */
    hasConsent(cookieClasses) {
        let consent = false;

        this._runSplitList(cookieClasses, (cookieClass) => {
            consent = Cookies.get(this._options.prefix + cookieClass) === 'true';

            // Return false if the current cookie class hasn't been consented to
            if (!consent) {
                return false;
            }
        });

        return consent;
    }

    /**
     * Consents to the cookie class.
     *
     * @param cookieClass the cookie class to consent to
     */
    consent(cookieClass) {
        this.setConsent(cookieClass, true);
    }

    /**
     * Sets the consent for a list of cookie classes.
     *
     * @param cookieClasses the cookie classes to set
     * @param {boolean, string} value
     */
    setConsent(cookieClasses, value) {
        this._runSplitList(cookieClasses, (cookieType) => {
            Cookies.set(this._options.prefix + cookieType, (value === true || value === 'true'), {expires: 365});

            this.runCallback(cookieType);
        });
    }

    /**
     * Runs a function on a comma-seperated list of strings.
     *
     * @param {string} str the comma-seperated list
     * @param {function} func the function to iterate over
     * @private
     */
    _runSplitList(str, func) {
        // First split the string into pieces
        let arr = str.toString().split(',');

        arr.forEach(func);
    }
}
