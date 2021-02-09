<?php
    declare(strict_types=1);

    namespace DDM\CookieNotice\Http\Controllers;

    use DDM\CookieNotice\Utilities;
    use Illuminate\Contracts\Foundation\Application;
    use Illuminate\Contracts\View\Factory;
    use Illuminate\Contracts\View\View;
    use Illuminate\Http\Request;
    use League\Flysystem\Util;
    use Statamic\Facades\Blueprint;
    use Statamic\Facades\File;
    use Statamic\Facades\Site;
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
        protected $configurationFile;

        public function __construct(Request $request) {
            parent::__construct($request);

            $this->locale = Utilities::getLocale();
            $this->configurationFile = 'content/ddm_cookie_notice_' . $this->locale . '.yaml';
        }

        public function index() {
            $blueprint = $this->getBlueprint();

            $fields = $blueprint->fields();
            $values = collect(YAML::file(__DIR__ . '/../' . $this->configurationFile)->parse())
                ->merge(YAML::file(base_path($this->configurationFile))->parse())
                ->all();
            $fields = $fields->addValues($values);
            $fields = $fields->preProcess();

            return view('cookie-notice::settings', [
                'blueprint' => $blueprint->toPublishArray(),
                'values' => $fields->values(),
                'meta' => $fields->meta()
            ]);
        }

        public function update(Request $request) {
            $blueprint = $this->getBlueprint();

            $fields = $blueprint->fields()->addValues($request->all());

            $fields->validate();

            $values = Arr::removeNullValues($fields->process()->values()->all());

            File::put(base_path($this->configurationFile), YAML::dump($values));
        }

        protected function getBlueprint(): \Statamic\Fields\Blueprint {
            return Blueprint::make()->setContents(YAML::file(__DIR__ . '/../../../resources/blueprints/cookie-notice-settings.yaml')->parse());
        }

    }
