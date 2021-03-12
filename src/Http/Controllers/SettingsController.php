<?php
	declare(strict_types=1);

	namespace DDM\CookieNotice\Http\Controllers;

	use DDM\CookieNotice\CookieNoticeApp;
	use DDM\CookieNotice\Settings\SettingsFields;
	use Illuminate\Http\Request;
	use Statamic\Facades\Blueprint;
	use Statamic\Facades\File;
	use Statamic\Facades\User;
	use Statamic\Facades\YAML;
	use Statamic\Http\Controllers\CP\CpController;
	use Statamic\Support\Arr;

	/**
	 * Class SettingsController
	 * @package DDM\DDMCookieNotice\Http\Controllers
	 * @author  dakralex
	 */
	class SettingsController extends CpController {

		protected $locale;
		protected string $configurationFile;

		public function __construct(Request $request) {
			parent::__construct($request);

			$this->locale = CookieNoticeApp::getLocale();
			$this->configurationFile = 'content/cookie_notice_' . $this->locale . '.yaml';
		}

		public function index() {
			// No access if the user doesn't have the right permissions to show them
			abort_unless(User::current()->can('configure settings'), 403);

			$blueprint = $this->getBlueprint();

			$fields = $blueprint
				->fields()
				->addValues(YAML::file(base_path($this->configurationFile))->parse())
				->preProcess();

			return view(CookieNoticeApp::NAMESPACE . '::settings', [
				'title' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_title'),
				'action' => cp_route(CookieNoticeApp::NAMESPACE . '.settings.index'),
				'blueprint' => $blueprint->toPublishArray(),
				'values' => $fields->values(),
				'meta' => $fields->meta()
			]);
		}

		public function update(Request  $request) {
			// No access if the user doesn't have the right permissions to show them
			abort_unless(User::current()->can('configure settings'), 403);

			$blueprint = $this->getBlueprint();

			$fields = $blueprint->fields()->addValues($request->all());

			$fields->validate();

			$values = Arr::removeNullValues($fields->process()->values()->all());

			File::put(base_path($this->configurationFile), YAML::dump($values));
		}

		protected function getBlueprint(): \Statamic\Fields\Blueprint {
			return Blueprint::make()
				->setContents(SettingsFields::getSettings());
			//return Blueprint::make()->setContents(YAML::file(__DIR__ . '/../../../resources/blueprints/cookie-notice-settings.yaml')->parse());
		}

	}
