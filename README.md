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
2. Install package with ``composer require ddm-studio/cookie-notice``
3. Publish Javascript with ``php please vendor:publish --tag="ddm-cookie-notice" -force``
4. Optional: Publish css to modify styles: ``php please vendor:publish --tag=ddm-cookie-notice-css --force``

4. Import the ``/resources/css/_cookie-notice.css`` into your stylesheet.
   

## Use

* Use ``{{ cookie_notice }}`` at the start of the body, to display the cookie modal and insert the Javascript code
* Use ``{{ if { cookie_notice:hasConsent cookieClasses="essential,thirdparty" } }}`` to check for the consent in templates
* In the configuration there can be many things added, like JavaScript which is called at the time of consenting to cookie classes.
