# ddm-studio/cookie-notice

## Installation

1. Add repository and install
   ```json
   "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/ddm-studio/cookie-notice"
        }
    ],
   "require": {
        "ddm-studio/ddm-cookie-notice": "*"
   }
   ```
2. Publish css and javascript files: ``php please vendor:publish --tag=ddm-cookie-notice --force``
3. Add ``/public/vendor/ddm-studio/cookie-notice/js/cookie-notice.min.js`` to your JavaScript mix and ``/resources/css/_cookie-notice.css`` to your CSS mix.
4. Use ``{{ cookie_notice }}``, and ``{{ if { cookie_notice:hasConsent consentClass="<consentClass>" } }}`` in PHP
   and ``hasConsent(<consentClass>)`` in JavaScript.
