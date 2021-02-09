const DISPLAY_SLEEP_TIME = 300;

export class CookieCover {
    /**
     *
     * @param {CookieConsent} instance
     */
    constructor(instance) {
        this._instance = instance;

        this._co_bgs = document.querySelectorAll('.ddmco-bg');
        this._co_overlays = {};

        this._co_bgs.forEach((overlay) => {
            console.log(overlay);

            this._co_overlays[overlay.id] = {
                slug: overlay.id,
                cookieTypes: overlay.dataset.types,
                htmlElement: overlay
            };
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

    show(slug) {
        if (slug in this._co_overlays) {
            let element = this._co_overlays[slug].htmlElement;

            element.style.display = 'block';

            setTimeout(() => {
                element.style.opacity = '1';
            }, 10);
        }
    }

    hide(slug) {
        if (slug in this._co_overlays) {
            let element = this._co_overlays[slug].htmlElement;

            element.style.opacity = '0';

            setTimeout(() => {
                element.style.display = 'none';
            }, DISPLAY_SLEEP_TIME);
        }
    }
}
