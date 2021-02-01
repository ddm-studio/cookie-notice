# ddm-studio/cookie-notice

## Installation

1. Add repository
   ```json
   "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/ddm-studio/cookie-notice"
        }
    ]
   ```
2. Add package and install with ``composer require ddm-studio/cookie-notice``
3. (Optional) Publish css files: ``php please vendor:publish --tag=ddm-cookie-notice-css --force``
4. Add ``/public/vendor/ddm-studio/cookie-notice/js/cookie-notice.min.js`` to your JavaScript mix and ``/resources/css/_cookie-notice.css`` to your CSS mix.
5. Use ``{{ cookie_notice }}``, and ``{{ if { cookie_notice:hasConsent consentClass="<consentClass>" } }}`` in PHP
   and ``hasConsent(<consentClass>)`` in JavaScript.
