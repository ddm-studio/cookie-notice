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
	 * Class CookieOverlay
	 * @package DDM\CookieNotice\Tags
	 * @author  dakralex
	 */
	class CookieOverlay extends Tags {

		/**
		 * @param null $consentOverlay
		 *
		 * @return Application|Factory|View
		 */
		public function index($consentOverlay) {
			$consentOverlay = $consentOverlay ?? $this->params->get('consentOverlay');

			$locale = Site::current()->locale();

			$blabla = collect(YAML::file(base_path('content/cookie-notice-settings_' . $locale . '.yaml'))->parse());

			var_dump($blabla);

			return view('cookie-notice::cookie-overlay', $blabla);
		}
	}