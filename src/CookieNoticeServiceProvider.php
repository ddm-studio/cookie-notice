<?php
	namespace DDM\CookieNotice;

	use DDM\CookieNotice\Tags\CookieNotice;
	use Statamic\Facades\CP\Nav;
	use Statamic\Facades\File;
	use Statamic\Facades\Permission;
	use Statamic\Providers\AddonServiceProvider;
	use Statamic\Statamic;

	/**
	 * The connection point between Statamic and this addon. This is where the magic begins.
	 *
	 * Class CookieNoticeServiceProvider
	 * @package DDM\CookieNotice
	 * @author  dakralex
	 */
	class CookieNoticeServiceProvider extends AddonServiceProvider {

		protected $routes = [
			'cp' => __DIR__ . '/../routes/cp.php',
		];

		protected $tags = [
			CookieNotice::class
		];

		protected $publishAfterInstall = false;

		/**
		 * Register all permissions, to give the end user some control over what their web masters and editors can do.
		 */
		protected function bootPermissions() {
			$this->app->booted(function () {
				Permission::group('cookie_notice_settings', __(CookieNoticeApp::NAMESPACE . '::cp.permissions_settings'), function () {
					Permission::register('configure settings', function ($permission) {
						$permission
							->label(__(CookieNoticeApp::NAMESPACE . '::cp.permission_configure_settings'))
							->description(__(CookieNoticeApp::NAMESPACE . '::cp.permission_configure_settings_description'));
						// This is for a future release, why do you like to spoil yourself?
//							->children([
//								Permission::make('edit text')
//									->label(__(CookieNoticeApp::NAMESPACE . '::cp.permission_edit_text'))
//									->description(__(CookieNoticeApp::NAMESPACE . '::cp.permission_edit_text_description')),
//								Permission::make('edit settings')
//									->label(__(CookieNoticeApp::NAMESPACE . '::cp.permission_edit_settings'))
//									->description(__(CookieNoticeApp::NAMESPACE . '::cp.permission_edit_settings_description')),
//								Permission::make('edit code')
//									->label(__(CookieNoticeApp::NAMESPACE . '::cp.permission_edit_code'))
//									->description(__(CookieNoticeApp::NAMESPACE . '::cp.permission_edit_code_description')),
//							]);
					});
				});
			});

			return $this;
		}

		protected function bootNavigation() {
			Nav::extend(function ($nav) {
				$cookieIconData = File::get(__DIR__ . '/../resources/svg/ddm-cookie.svg');

				// Cookie notice settings
				$nav->create(__(CookieNoticeApp::NAMESPACE . '::cp.navigation_item_title'))
					->section('Tools')
					->can(auth()->user()->can('show settings'))
					->route(CookieNoticeApp::NAMESPACE . '.settings.index')
					->icon($cookieIconData ?? 'alert');
			});

			return $this;
		}

		protected function publishAssets() {
			Statamic::afterInstalled(function ($command) {
				// Publish default settings, to make the first time experience more joyful
				$command->call('vendor:publish', ['--tag' => CookieNoticeApp::NAMESPACE . '-settings']);

				// Force JavaScript updates, so it's overwritten on every new install
				$command->call('vendor:publish', ['--tag' => CookieNoticeApp::NAMESPACE . '-resource-js', '--force' => true]);
				$command->call('vendor:publish', ['--tag' => CookieNoticeApp::NAMESPACE . '-resource-css']);
			});

			return $this;
		}

		/**
		 * Bootstrap all the stuff this addons offers to the Laravel/Statamic universe.
		 */
		public function boot() {
			parent::boot();

			$this->loadTranslationsFrom(__DIR__ . '/../resources/lang', CookieNoticeApp::NAMESPACE);
			$this->loadViewsFrom(__DIR__ . '/../resources/views', CookieNoticeApp::NAMESPACE);

			$this
				->bootPermissions()
				->bootNavigation()
				->publishAssets();

			if ($this->app->runningInConsole()) {
				$this->publishes([
					__DIR__ . '/../content/cookie_notice_en_US.default.yaml' => base_path('content/cookie_notice_en_US.yaml'),
					__DIR__ . '/../content/cookie_notice_de_DE.default.yaml' => base_path('content/cookie_notice_de_DE.yaml'),
				], CookieNoticeApp::NAMESPACE . '-settings');

				$this->publishes([
					__DIR__ . '/../resources/dist/js' => public_path('vendor/' . CookieNoticeApp::NAMESPACE . '/js'),
				], CookieNoticeApp::NAMESPACE . '-resource-js');
				$this->publishes([
					__DIR__ . '/../resources/css' => resource_path('css/'),
				], CookieNoticeApp::NAMESPACE . '-resource-css');

				$this->publishes([
					__DIR__ . '/../resources/views' => resource_path('views/vendor/' . CookieNoticeApp::NAMESPACE),
				], CookieNoticeApp::NAMESPACE . '-views');

				$this->publishes([
					__DIR__ . '/../resources/lang' => resource_path('lang/vendor/' . CookieNoticeApp::NAMESPACE),
				], CookieNoticeApp::NAMESPACE . '-views');
			}
		}
	}
