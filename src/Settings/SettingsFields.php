<?php

	namespace DDM\CookieNotice\Settings;

	use DDM\CookieNotice\CookieNoticeApp;

	/**
	 * Class SettingsFields
	 * @package DDM\CookieNotice
	 * @author  dakralex
	 */
	class SettingsFields {

		public static function getSettings() {
			return [
				'sections' => [
					'general' => [
						'display' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_tab_general'),
						'fields' => [
							[
								'handle' => 'enabled',
								'field' => [
									'type' => 'toggle',
									'display' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_enabled'),
									'instructions' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_enabled_instruction'),
								]
							],
							[
								'handle' => 'classes',
								'field' => [
									'type' => 'grid',
									'display' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_classes'),
									'instructions' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_classes_instruction'),
									'add_row' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_classes_add_row'),
									'mode' => 'stacked',
									'reorderable' => true,
									'fields' => [
										[
											'handle' => 'title',
											'field' => [
												'type' => 'text',
												'display' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_class_title'),
												'instructions' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_class_title_instruction'),
												'placeholder' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_class_title_placeholder'),
												'validate' => [ 'required' ],
												'width' => 33
											]
										],
										[
											'handle' => 'handle',
											'field' => [
												'type' => 'slug',
												'display' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_class_handle'),
												'instructions' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_class_handle_instruction'),
												'placeholder' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_class_handle_placeholder'),
												'generate' => true,
												'validate' => [ 'required' ],
												'width' => 33
											]
										],
										[
											'handle' => 'required',
											'field' => [
												'type' => 'toggle',
												'display' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_class_required'),
												'instructions' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_class_required_instruction'),
												'width' => 33
											]
										],
										[
											'handle' => 'description',
											'field' => [
												'type' => 'textarea',
												'display' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_class_description'),
												'instructions' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_class_description_instruction'),
												'placeholder' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_class_description_placeholder'),
											]
										],
										[
											'handle' => 'code_snippets',
											'field' => [
												'type' => 'grid',
												'display' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_class_code_snippets'),
												'instructions' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_class_code_snippets_instruction'),
												'add_row' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_class_code_snippets_add_row'),
												'fields' => [
													[
														'handle' => 'code',
														'field' => [
															'type' => 'code',
															'display' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_class_code_snippets'),
															'mode' => 'javascript',
															'theme' => 'light',
															'indent_type' => 'tabs',
															'indent_size' => 4,
															'line_numbers' => true,
															'line_wrapping' => true
														]
													]
												]
											]
										]
									]
								]
							],
							[
								'handle' => 'developer_section',
								'field' => [
									'type' => 'section',
									'display' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_developer_section'),
									'instructions' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_developer_section_instruction')
								]
							],
							[
								'handle' => 'custom_code',
								'field' => [
									'type' => 'toggle',
									'display' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_custom_code'),
									'instructions' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_custom_code_instruction')
								]
							]
						]
					],
					'modal' => [
						'display' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_tab_modal'),
						'fields' => [
							[
								'handle' => 'modal_section',
								'field' => [
									'type' => 'section',
									'display' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_modal_section'),
									'instructions' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_modal_section_instruction')
								]
							],
							[
								'handle' => 'modal_title',
								'field' => [
									'type' => 'text',
									'display' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_modal_title'),
									'instructions' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_modal_title_instruction'),
									'placeholder' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_modal_title_placeholder'),
									'validate' => [ 'required' ]
								]
							],
							[
								'handle' => 'modal_description',
								'field' => [
									'type' => 'textarea',
									'display' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_modal_description'),
									'instructions' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_modal_description_instruction'),
									'placeholder' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_modal_description_placeholder'),
									'validate' => [ 'required' ]
								]
							],
							[
								'handle' => 'modal_button_all',
								'field' => [
									'type' => 'text',
									'display' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_modal_button_all'),
									'instructions' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_modal_button_all_instruction'),
									'placeholder' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_modal_button_all_placeholder'),
									'validate' => [ 'required' ],
									'width' => 50
								]
							],
							[
								'handle' => 'modal_button_selected',
								'field' => [
									'type' => 'text',
									'display' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_modal_button_selected'),
									'instructions' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_modal_button_selected_instruction'),
									'placeholder' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_modal_button_selected_placeholder'),
									'validate' => [ 'required' ],
									'width' => 50
								]
							],
						]
					],
					'covers' => [
						'display' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_tab_covers'),
						'fields' => [
							[
								'handle' => 'covers_section',
								'field' => [
									'type' => 'section',
									'display' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_covers_section'),
									'instructions' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_covers_section_instruction')
								]
							],
							[
								'handle' => 'covers',
								'field' => [
									'type' => 'grid',
									'display' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_covers'),
									'instructions' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_covers_instruction'),
									'add_row' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_covers_add_row'),
									'mode' => 'stacked',
									'reorderable' => true,
									'fields' => [
										[
											'handle' => 'handle',
											'field' => [
												'type' => 'slug',
												'display' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_cover_handle'),
												'instructions' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_cover_handle_instruction'),
												'placeholder' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_cover_handle_placeholder'),
												'generate' => false,
												'validate' => [ 'required', 'alpha' ],
												'width' => 33
											]
										],
										[
											'handle' => 'classes',
											'field' => [
												'type' => 'text',
												'display' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_cover_classes'),
												'instructions' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_cover_classes_instruction'),
												'placeholder' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_cover_classes_placeholder'),
												'validate' => [ 'required' ],
												'width' => 66
											]
										],
										[
											'handle' => 'title',
											'field' => [
												'type' => 'text',
												'display' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_cover_title'),
												'instructions' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_cover_title_instruction'),
												'placeholder' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_cover_title_placeholder'),
												'validate' => [ 'required' ]
											]
										],
										[
											'handle' => 'paragraph',
											'field' => [
												'type' => 'textarea',
												'display' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_cover_paragraph'),
												'instructions' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_cover_paragraph_instruction'),
												'placeholder' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_cover_paragraph_placeholder'),
											]
										],
										[
											'handle' => 'button_accept',
											'field' => [
												'type' => 'text',
												'display' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_cover_button_accept'),
												'instructions' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_cover_button_accept_instruction'),
												'placeholder' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_cover_button_accept_placeholder'),
												'validate' => [ 'required' ]
											]
										],
										[
											'handle' => 'bg_image',
											'field' => [
												'type' => 'text',
												'display' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_cover_bg_image'),
												'instructions' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_cover_bg_image_instruction'),
												'placeholder' => __(CookieNoticeApp::NAMESPACE . '::cp.settings_cover_bg_image_placeholder'),
											]
										]
									]
								]
							]
						]
					]
				]
			];
		}
// __(CookieNoticeApp::NAMESPACE . '::cp.settings_')
	}