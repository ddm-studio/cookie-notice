<?php
	declare(strict_types=1);

	/**
	 * Control panel routes
	 */

	use DDM\CookieNotice\CookieNoticeApp;
	use DDM\CookieNotice\Http\Controllers\SettingsController;

	Route::prefix(CookieNoticeApp::NAMESPACE . '/')->name(CookieNoticeApp::NAMESPACE . '.')->group(function () {
		Route::name('settings.')->group(function () {
			Route::get('/', [SettingsController::class, 'index'])->name('index');
			Route::post('/', [SettingsController::class, 'update'])->name('update');
		});
	});