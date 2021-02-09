<?php
	declare(strict_types=1);

	namespace DDM\CookieNotice;

	use Statamic\Facades\Site;
    use Statamic\Facades\YAML;

    /**
	 * Class Utilities
	 * @package DDM\CookieNotice
	 * @author  dakralex
	 */
	class Utilities {

        /**
         * Returns the correct current locale for control panel or site use.
         *
         * @return mixed
         */
        public static function getLocale() {
            return session('statamic.cp.selected-site') ? Site::get(session('statamic.cp.selected-site'))->locale() : Site::current()->locale();
        }

	}
