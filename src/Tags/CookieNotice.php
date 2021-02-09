<?php
    declare(strict_types=1);

    namespace DDM\CookieNotice\Tags;

    use DDM\CookieNotice\Utilities;
    use Illuminate\Contracts\Foundation\Application;
    use Illuminate\Contracts\View\Factory;
    use Illuminate\Contracts\View\View;
    use JShrink\Minifier;
    use Statamic\Facades\Site;
    use Statamic\Facades\YAML;
    use Statamic\Tags\Tags;

    /**
     * Class CookieConsent
     * @package DDM\CookieConsentTool
     * @author  dakralex
     */
    class CookieNotice extends Tags {

        protected $locale;
        protected $configurationFile;

        public function initialize() {
            $this->locale = Utilities::getLocale();
            $this->configurationFile = 'content/ddm_cookie_notice_' . $this->locale . '.yaml';
        }

        /**
         * Inserts the cookie modal with its content and adds the Javascript code.
         *
         * @return Application|Factory|View
         * @throws \Exception
         */
        public function index() {
            $this->initialize();

            $data = YAML::file(base_path($this->configurationFile))->parse();

            $this->injectLoadScript($data);

            return view('cookie-notice::cookie-modal', collect($data));
        }

        /**
         * Checks whether the cookie class or cookie classes have already been consented to.
         * If no parameter is given, it checks if the cookie modal has already been accepted.
         *
         * @param string|null $cookieClasses the cookie class or a list of cookie classes
         *
         * @return bool whether the cookie class has already been consented to
         */
        public function hasConsent($cookieClasses = null): bool {
            $cookieClasses = $cookieClasses ?? $this->params->get('cookieClasses') ?? 'showed';

            // Seperate the list by comma
            $cookieClasses = explode(',', $cookieClasses);

            $consent = false;

            foreach ($cookieClasses as &$cookieType) {
                if (array_key_exists('ddm-cookie-consent-' . $cookieType, $_COOKIE)) {
                    $consent = $_COOKIE['ddm-cookie-consent-' . $cookieType] === 'true';
                }
            }

            return $consent;
        }

        /**
         * Inserts the cookie cover with the given handle. If it doesn't exist, it won't output anything.
         *
         * @param string|null $handle
         *
         * @return Application|Factory|View|void
         */
        public function cover(string $handle = null) {
            $this->initialize();
            $handle = $handle ?? $this->params->get('handle');

            $data = YAML::file(base_path($this->configurationFile))->parse();

            // Stop execution if there are no cookie covers
            if (!array_key_exists('covers', $data))
                return;

            // Find cookie cover with the given handle
            $cover = null;
            foreach ($data['covers'] as &$current_cover) {
                if ($current_cover['handle'] === $handle) {
                    $cover = $current_cover;
                }
            }

            // Stop execution if it wasn't found
            if ($cover === null)
                return;

            // Add cover-specific variables into view data
            $data = array_merge($data, $cover);

            return view('cookie-notice::cookie-cover', collect($data));
        }

        /**
         * Adds a variable with JavaScript in the view's data, so that the cookie notice code will be loaded with all
         * registered callbacks into DOM, when the whole page has been sucessfully loaded.
         *
         * @param $data
         *
         * @throws \Exception
         */
        private function injectLoadScript(&$data) {
            // TODO: Some better generation process
            // TODO: Add possibility to initialize cookie consents in own code

            $data['load_code'] = '<script>';

            // Define _ddmCCLoad function which loads dynamically injected callbacks
            $data['load_code'] .= 'var _ddmCCLoad=()=>{';

            // Loop through every code snippet and add register callback code
            if (array_key_exists('classes', $data)) {
                foreach ($data['classes'] as &$class) {
                    if (array_key_exists('code_snippets', $class)) {
                        foreach ($class['code_snippets'] as &$codeSnippet) {
                            $data['load_code'] .= 'window.CookieConsent.registerCallback("' . $class['handle'] . '",()=>{' . str_replace('\'', '"', Minifier::minify($codeSnippet['code'])) . '});';
                        }
                    }
                }
            }

            // Add runCallbacks function and close _ddmCCload
            $data['load_code'] .= 'window.CookieConsent.runCallbacks()};';

            // Add event listener when document finished loading
            $data['load_code'] .= 'document.addEventListener("DOMContentLoaded",()=>{';

            // Add pre-compiled script and after its load call _ddmCCLoad
            $data['load_code'] .= 'var a=document.createElement("script");a.setAttribute("src","/vendor/ddm-studio/cookie-notice/js/cookie-notice.min.js");a.addEventListener(\'load\', _ddmCCLoad);document.body.appendChild(a);';

            $data['load_code'] .= '});</script>';
        }

    }
