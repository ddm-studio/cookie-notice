<?php

	namespace DDM\CookieNotice;

	use Statamic\Facades\Site;

	/**
	 * Class Utilities
	 * @package DDM\CookieNotice
	 * @author  dakralex
	 */
	class CookieNoticeApp {

		public const NAMESPACE = "cookie-notice";

		/**
		 * Returns the current locale. For the control panel AND the site itself.
		 *
		 * @return mixed
		 */
		public static function getLocale() {
			return session('statamic.cp.selected-site') ? Site::get(session('statamic.cp.selected-site'))->locale() : Site::current()->locale();
		}

	}
