<?php
    declare(strict_types=1);

    namespace DDM\DDMCookieNotice;

    use DDM\DDMCookieNotice\Tags\CookieNotice;
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

        protected $tags = [
            CookieNotice::class
        ];

        public function boot() {
            parent::boot();
            
            Statamic::booted(function () {
                // Register settings routes
                $this->registerCpRoutes(function () {
                    Route::prefix('ddm-studio/cookie-notice/')->name('ddm-studio.cookie-notice.')->group(function () {
                        Route::get('/', 'SettingsController@index')->name('index');
                        Route::post('/', 'SettingsController@update')->name('update');
                    });
                });

                $this->publishes([
                    __DIR__ . '/../resources/dist/js' => public_path('/vendor/ddm-studio/cookie-notice/js'),
                    __DIR__ . '/../resources/css' => resource_path('css/')
                ], 'ddm-cookie-notice');

                $this->loadViewsFrom(__DIR__ . '/../resources/views/', 'cookie-notice');

                Nav::extend(function ($nav) {
                    $nav->content('Cookie Hinweis')
                        ->section('Tools')
                        ->route('ddm-studio.cookie-notice.index')
                        ->icon('alert');
                });
            });
        }
    }
