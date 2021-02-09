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
            $this->configurationFile = 'content/cookie-notice-settings_' . $this->locale . '.yaml';
        }

        public function index() {
            $this->initialize();

            $data = YAML::file(base_path($this->configurationFile))->parse();

            if (is_array($data['cookie-types'])) {
                $data['js_snippet'] = $this->generateScriptLoad($data['cookie-types']);
            }

            var_dump($data);

            return view('cookie-notice::cookie-modal', collect($data));
        }

        /**
         * Returns either if the consent for a specific class has been given or, if no parameter was given, it has been showed and accepted.
         *
         * @param string|null $cookieType
         *
         * @return bool
         */
        public function hasConsent($cookieType = null): bool {
            $cookieType = $cookieType ?? $this->params->get('cookieType') ?? 'showed';

            if (isset($_COOKIE['cookie-consent-' . $cookieType]))
                return $_COOKIE['cookie-consent-' . $cookieType] === 'true';
            else
                return false;
        }

        /**
         * @param $slug
         *
         * @return Application|Factory|View|void
         */
        public function overlay(string $slug = null) {
            $slug = $slug ?? $this->params->get('slug');

            $cookieOverlays = YAML::file(base_path('content/cookie-notice-settings_' . Utilities::getLocale() . '.yaml'))->parse()['cookie-overlays'];

            $overlayData = $this->getOverlayData($slug, $cookieOverlays);

            if (!is_array($overlayData))
                return;

            return view('cookie-notice::cookie-overlay', collect(array_merge(YAML::file(base_path('content/cookie-notice-settings_' . Utilities::getLocale() . '.yaml'))->parse(), $overlayData)));
        }

        /**
         * @param       $slug
         * @param array $haystack
         *
         * @return false|array
         */
        private function getOverlayData($slug, array $haystack) {
            foreach ($haystack as $needle) {
                if ($needle['slug'] === $slug) {
                    return $needle;
                }
            }

            return false;
        }

        private function generateScriptLoad($cookie_types) {
            $code = 'var loadCC = () => {';
            $code .= 'var s = document.createElement(\'script\');';
            $code .= 's.text = "';

            foreach ($cookie_types as &$type) {
                if (is_array($type['code-snippets'])) {
                    foreach ($type['code-snippets'] as &$code_snippet) {
                        $code .= 'window.CookieConsent.registerCallback(\'' . $type['slug'] . '\', () => {' . $code_snippet['code'] . '});';
                    }
                }
            }

            $code .= 'window.CookieConsent._runConsentedCallbacks()";';
            $code .= 'document.head.appendChild(s)};';
            $code .= 'document.readyState === "loading" ? document.addEventListener("DOMContentLoaded", loadCC) : loadCC()';

            $code = trim(preg_replace('/\s+/', ' ', $code));

            var_dump($code);

            return $code;
        }

    }
