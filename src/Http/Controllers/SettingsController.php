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
                            0 => [
                                'handle' => 'cookie-notice-show',
                                'field' => [
                                    'display' => 'Cookie-Hinweis aktivieren',
                                    'type' => 'toggle',
                                    'icon' => 'toggle'
                                ]
                            ],
                            1 => [
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
                            2 => [
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
                            3 => [
                                'handle' => 'cookie-notice-button-all',
                                'field' => [
                                    'display' => 'Button "Alle auswählen"',
                                    'type' => 'text',
                                    'icon' => 'text',
                                    'input_type' => 'text',
                                    'placeholder' => 'Alle auswählen',
                                    'width' => 33,
                                    'if' => ['cookie-notice-show' => 'equals true']
                                ]
                            ],
                            4 => [
                                'handle' => 'cookie-notice-button-selected',
                                'field' => [
                                    'display' => 'Button "Auswahl bestätigen"',
                                    'type' => 'text',
                                    'icon' => 'text',
                                    'input_type' => 'text',
                                    'placeholder' => 'Auswahl bestätigen',
                                    'width' => 33,
                                    'if' => ['cookie-notice-show' => 'equals true']
                                ]
                            ],
	                        5 => [
		                        'handle' => 'cookie-notice-button-accept',
		                        'field' => [
			                        'display' => 'Button "Cookies akzeptieren"',
			                        'type' => 'text',
			                        'icon' => 'text',
			                        'input_type' => 'text',
			                        'placeholder' => 'Cookies akzeptieren',
			                        'width' => 33,
			                        'if' => ['cookie-notice-show' => 'equals true']
		                        ]
	                        ],
	                        6 => [
		                        'handle' => 'section-cookie-consent-classes',
		                        'field' => [
			                        'display' => 'Cookie-Typen',
			                        'type' => 'section',
			                        'icon' => 'section',
			                        'instructions' => 'Hier können Cookie-Typen für das Cookie Notice und Overlays erstellt werden.'
		                        ]
	                        ],
	                        7 => [
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
			                        'display' => 'Cookie-Typen',
			                        'mode' => 'stacked',
			                        'type' => 'grid',
			                        'icon' => 'grid',
			                        'reorderable' => true,
			                        'if' => ['cookie-notice-show' => 'equals true']
		                        ],
	                        ],
	                        8 => [
	                        	'handle' => 'section-cookie-overlays',
		                        'field' => [
		                        	'display' => 'Cookie-Overlays',
			                        'type' => 'section',
			                        'icon' => 'section',
			                        'instructions' => 'Hier können Cookie-Overlays erstellt werden, die z.B. Drittanbieter-Libraries verdecken.'
		                        ]
	                        ],
	                        9 => [
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
						                        'instructions' => 'Geben Sie den Pfad zu einem eindrucksvollen Hintergrundbild relativ zum public-Ordner an.',
						                        'type' => 'text',
						                        'icon' => 'assets',
						                        'input_type' => 'text'
					                        ],
				                        ],
			                        ],
			                        'display' => 'Cookie-Overlays',
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
