export class CookieModal {
    /**
     *
     * @param {CookieConsent} instance
     */
    constructor(instance) {
        this._instance = instance;

        this._cn_bg = document.querySelector('.ddmcn-bg');
        this._cn_checks = this._cn_bg.querySelectorAll('.cookie-types input[type=\"checkbox\"]');
        this._cn_checks_not_checked = () => this._cn_bg.querySelectorAll('.cookie-types input[type=\"checkbox\"]:not(:checked)');

        this._cn_btn_all = document.querySelector('#ddmcn-button-all');
        this._cn_btn_selected = document.querySelector('#ddmcn-button-selected');

        // Check all previously checked consents, except the ones which are required anyways
        this._cn_checks_not_checked().forEach((check) => {
            check.checked = this._instance.hasConsent(check.name);
        });

        this._cn_btn_all.addEventListener('click', (event) => {
            event.preventDefault();

            this.checkAll();

            this._finalize();
        });

        this._cn_btn_selected.addEventListener('click', (event) => {
            event.preventDefault();

            this._finalize();
        });

        // Show the cookie notice if it hasn't already been interacted with
        if (!this._instance.hasConsent('showed')) {
            this.show();
        }
    }

    show() {
        this._cn_bg.style.display = 'block';
        setTimeout(() => {
            this._cn_bg.style.opacity = '1';
        }, 10);
    }

    hide() {
        this._cn_bg.style.opacity = '0';
        setTimeout(() => {
            this._cn_bg.style.display = 'none';
        }, DISPLAY_SLEEP_TIME);
    }

    checkAll() {
        this._cn_checks_not_checked().forEach((check) => check.click());
    }

    /**
     * Sets and pushes consent for all checked cookie type checkboxes.
     * @private
     */
    _pushSettings() {
        this._cn_checks.forEach((check) => {
            if (check.checked) {
                this._instance.consent(check.name);
            }
        });

        this._instance.consent('showed');
    }

    /**
     * Finalizes interaction with the cookie notice tool.
     * @private
     */
    _finalize() {
        this._pushSettings();

        setTimeout(this.hide.bind(this), DISPLAY_SLEEP_TIME);
    }
}
