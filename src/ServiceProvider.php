<?php
    declare(strict_types=1);

    namespace DDM\CookieNotice;

    use DDM\CookieNotice\Http\Controllers\SettingsController;
    use DDM\CookieNotice\Tags\CookieNotice;
    use Illuminate\Support\Facades\Route;
    use Statamic\Facades\CP\Nav;
    use Statamic\Providers\AddonServiceProvider;
    use Statamic\Statamic;

    /**
     * Class ServiceProvider
     * @package DDM\CookieConsentTool
     * @author  dakralex
     */
    class ServiceProvider extends AddonServiceProvider {

        /**
         * All of the addons tags
         *
         * @var string[] tag class identifiers
         */
        protected $tags = [
            CookieNotice::class
        ];

        /**
         * This function is called at boot time of the addon
         */
        public function boot() {
            parent::boot();

            // Wait until Statamic itself has booted up
            Statamic::booted(function () {
                // Register settings routes
                $this->registerCpRoutes(function () {
                    Route::prefix('ddm-studio/cookie-notice/')->name('ddm-studio.cookie-notice.')->group(function () {
                    	Route::get('/', [SettingsController::class, 'index'])->name('index');
                    	Route::post('/', [SettingsController::class, 'update'])->name('update');
                    });
                });

                // Register vendor:publish routes
                $this->publishes([
                    __DIR__ . '/../resources/dist/js' => public_path('vendor/ddm-studio/cookie-notice/js/'),
	                __DIR__ . '/../resources/css' => resource_path('css/')
                ], 'ddm-cookie-notice-css');

                // Setting up namespace and loaded views
                $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'cookie-notice');

                // Add cookie notice in the navigation
                Nav::extend(function ($nav) {
                    $nav->content('Cookie Hinweis')
                        ->section('Tools')
                        ->route('ddm-studio.cookie-notice.index')
                        ->icon('alert');
                });
            });
        }
    }
