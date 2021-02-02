<?php
    declare(strict_types=1);

    namespace DDM\CookieNotice\Tags;

    use Illuminate\Contracts\Foundation\Application;
    use Illuminate\Contracts\View\Factory;
    use Illuminate\Contracts\View\View;
    use Statamic\Facades\Site;
    use Statamic\Facades\YAML;
    use Statamic\Tags\Tags;

    /**
     * Class CookieConsent
     * @package DDM\CookieConsentTool
     * @author  dakralex
     */
    class CookieNotice extends Tags {

        /**
         * @return Application|Factory|View
         */
        public function index() {
            $locale = Site::current()->locale();

            return view('cookie-notice::cookie-notice', collect(YAML::file(base_path('content/cookie-notice-settings_' . $locale . '.yaml'))->parse()));
        }

        /**
         * Returns either if the consent for a specific class has been given or, if no parameter was given, it has been showed and accepted.
         *
         * @param null $consentClass
         *
         * @return bool
         */
        public function hasConsent($consentClass = null): bool {
            $consentClass = $consentClass ?? $this->params->get('consentClass') ?? 'showed';

            if ($cookieConsent = $_COOKIE['cookie-consent-' . $consentClass])
                return $cookieConsent === 'true';
            else
                return false;
        }
    }
