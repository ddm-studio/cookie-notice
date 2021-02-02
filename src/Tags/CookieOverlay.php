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
		 * @param $slug
		 *
		 * @return Application|Factory|View|void
		 */
		public function index(string $slug = null) {
			$slug = $slug ?? $this->params->get('slug');

			$locale = Site::current()->locale();

			$cookieOverlays = YAML::file(base_path('content/cookie-notice-settings_' . $locale . '.yaml'))->parse()['cookie-overlays'];

			$overlayData = $this->getOverlayData($slug, $cookieOverlays);

			if (!is_array($overlayData))
				return;

			 return view('cookie-notice::cookie-overlay', $overlayData);
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
	}
