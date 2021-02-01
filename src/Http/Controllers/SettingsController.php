<?php
    declare(strict_types=1);

    namespace DDM\CookieNotice\Http\Controllers;

    use Illuminate\Contracts\Foundation\Application;
    use Illuminate\Contracts\View\Factory;
    use Illuminate\Contracts\View\View;
    use Illuminate\Http\Request;
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

        public function __construct(Request $request) {
            $this->locale = session('statamic.cp.selected-site') ? Site::get(session('statamic.cp.selected-site')) : Site::current()->locale();

            parent::__construct($request);
        }

        /**
         * @return Application|Factory|View
         */
        public function index() {
            $blueprint = $this->formBlueprint();

            $fields = $blueprint->fields();
            $values = collect(YAML::file(__DIR__ . '/../content/cookie-notice-settings_' . $this->locale . '.yaml')->parse())
                ->merge(YAML::file(base_path('content/cookie-notice-settings_' . $this->locale . '.yaml'))->parse())
                ->all();
            $fields = $fields->addValues($values);
            $fields = $fields->preProcess();

            return view('cookie-notice::settings', [
                'blueprint' => $blueprint->toPublishArray(),
                'values' => $fields->values(),
                'meta' => $fields->meta()
            ]);
        }

        /**
         * @return \Statamic\Fields\Blueprint
         */
        protected function formBlueprint(): \Statamic\Fields\Blueprint {
            return Blueprint::make()->setContents([
                'sections' => [
                    'main' => [
                        'display' => 'Hauptteil',
                        'fields' => [
                            1 => [
                                'handle' => 'cookie-notice-show',
                                'field' => [
                                    'display' => 'Cookie-Hinweis aktivieren',
                                    'type' => 'toggle',
                                    'icon' => 'toggle'
                                ]
                            ],
                            2 => [
                                'handle' => 'cookie-notice-title',
                                'field' => [
                                    'display' => 'Titel des Modals',
                                    'type' => 'text',
                                    'icon' => 'text',
                                    'placeholder' => 'Cookie-Einstellungen',
                                    'instructions' => 'Geben Sie dem Cookie-Hinweis einen Titel.',
                                    'input_type' => 'text',
                                    'if' => ['cookie-notice-show' => 'equals true']
                                ],
                            ],
                            3 => [
                                'handle' => 'cookie-notice-text',
                                'field' => [
                                    'display' => 'Text des Modals',
                                    'type' => 'textarea',
                                    'icon' => 'textarea',
                                    'instructions' => 'Beschreiben Sie hier kurz was die Cookies auf der Seite tun.',
                                    'placeholder' => 'Wir verwenden Cookies, um Ihnen auf unserer Website ein optimales Erlebnis zu bieten.',
                                    'if' => ['cookie-notice-show' => 'equals true']
                                ],
                            ],
                            4 => [
                                'handle' => 'cookie-notice-button-all',
                                'field' => [
                                    'display' => 'Button "Alle auswählen"',
                                    'type' => 'text',
                                    'icon' => 'text',
                                    'input_type' => 'text',
                                    'placeholder' => 'Alle auswählen',
                                    'width' => 50,
                                    'if' => ['cookie-notice-show' => 'equals true']
                                ]
                            ],
                            5 => [
                                'handle' => 'cookie-notice-button-selected',
                                'field' => [
                                    'display' => 'Button "Auswahl bestätigen"',
                                    'type' => 'text',
                                    'icon' => 'text',
                                    'input_type' => 'text',
                                    'placeholder' => 'Auswahl bestätigen',
                                    'width' => 50,
                                    'if' => ['cookie-notice-show' => 'equals true']
                                ]
                            ],
                            6 => [
                                'handle' => 'cookie-consent-classes',
                                'field' => [
                                    'fields' => [
                                        0 => [
                                            'handle' => 'slug',
                                            'field' => [
                                                'display' => 'Slug',
                                                'type' => 'text',
                                                'icon' => 'text',
                                                'input_type' => 'text',
                                                'width' => 25
                                            ],
                                        ],
                                        1 => [
                                            'handle' => 'title',
                                            'field' => [
                                                'display' => 'Bezeichnung',
                                                'type' => 'text',
                                                'icon' => 'text',
                                                'input_type' => 'text',
                                                'width' => 50
                                            ],
                                        ],
                                        2 => [
                                            'handle' => 'required',
                                            'field' => [
                                                'display' => 'Erforderlich',
                                                'type' => 'toggle',
                                                'icon' => 'toggle',
                                                'width' => 25
                                            ]
                                        ],
                                        3 => [
                                            'handle' => 'description',
                                            'field' => [
                                                'display' => 'Beschreibung',
                                                'type' => 'textarea',
                                                'icon' => 'textarea'
                                            ],
                                        ],
                                    ],
                                    'display' => 'Zustimmungsklassen',
                                    'mode' => 'stacked',
                                    'type' => 'grid',
                                    'icon' => 'grid',
                                    'reorderable' => true,
                                    'if' => ['cookie-notice-show' => 'equals true']
                                ],
                            ],
	                        7 => [
		                        'handle' => 'cookie-overlays',
		                        'field' => [
			                        'fields' => [
				                        0 => [
					                        'handle' => 'slug',
					                        'field' => [
						                        'display' => 'Slug',
						                        'type' => 'text',
						                        'icon' => 'text',
						                        'input_type' => 'text',
						                        'width' => 25
					                        ],
				                        ],
				                        1 => [
					                        'handle' => 'consent-classes',
					                        'field' => [
						                        'display' => 'Notwendige Zustimmungsklassen',
						                        'instructions' => 'Geben Sie die zu akzeptierenden Zustimmungsklassen an.',
						                        'type' => 'text',
						                        'icon' => 'text',
						                        'input_type' => 'text',
						                        'width' => 75
					                        ],
				                        ],
				                        2 => [
					                        'handle' => 'title',
					                        'field' => [
						                        'display' => 'Bezeichnung',
						                        'type' => 'text',
						                        'icon' => 'text',
						                        'input_type' => 'text'
					                        ]
				                        ],
				                        3 => [
					                        'handle' => 'description',
					                        'field' => [
						                        'display' => 'Beschreibung',
						                        'type' => 'textarea',
						                        'icon' => 'textarea'
					                        ],
				                        ],
				                        4 => [
				                        	'handle' => 'background-image',
					                        'field' => [
					                        	'display' => 'Hintergrundbild',
						                        'instructions' => 'Laden Sie hier ein Hintergrundbild hoch, um dem User zu zeigen, warum er die Cookies akzeptieren soll.',
						                        'type' => 'assets',
						                        'icon' => 'assets',
						                        'max_files' => 1,
						                        'allow_uploads' => true
					                        ],
				                        ],
			                        ],
			                        'display' => 'Zustimmungsklassen',
			                        'mode' => 'stacked',
			                        'type' => 'grid',
			                        'icon' => 'grid',
			                        'reorderable' => true,
			                        'if' => ['cookie-notice-show' => 'equals true']
		                        ],
	                        ],
                        ],
                    ],
                ],
            ]);
        }

        /**
         * @param Request $request
         */
        public function update(Request $request) {
            $blueprint = $this->formBlueprint();

            $fields = $blueprint->fields()->addValues($request->all());

            $fields->validate();

            $values = Arr::removeNullValues($fields->process()->values()->all());

            File::put(base_path('content/cookie-notice-settings_' . $this->locale . '.yaml'), YAML::dump($values));
        }
    }
