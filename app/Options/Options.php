<?php
/**
 * Options
 *
 * @package NSNepaliDate
 */

namespace NSNepaliDate\Options;

use Nilambar\Optioner\Optioner;

/**
 * Options class.
 *
 * @since 1.0.0
 */
class Options {

	/**
	 * Register.
	 *
	 * @since 1.0.0
	 */
	public function register() {
		add_action( 'optioner_admin_init', array( $this, 'register_plugin_options' ) );
	}

	/**
	 * Register plugin options.
	 *
	 * @since 1.0.0
	 */
	public function register_plugin_options() {
		$obj = new Optioner();

		$obj->set_page(
			array(
				'page_title'     => esc_html__( 'NS Nepali Date', 'ns-nepali-date' ),
				/* translators: %s: version. */
				'page_subtitle'  => sprintf( esc_html__( 'Version: %s', 'ns-nepali-date' ), NS_NEPALI_DATE_VERSION ),
				'menu_title'     => esc_html__( 'NS Nepali Date', 'ns-nepali-date' ),
				'capability'     => 'manage_options',
				'menu_slug'      => 'ns-nepali-date',
				'option_slug'    => 'nsnd_plugin_options',
				'top_level_menu' => false,
			)
		);

		$obj->set_quick_links(
			array(
				array(
					'text' => 'Plugin Page',
					'url'  => 'https://github.com/ernilambar/ns-nepali-date/',
					'type' => 'primary',
				),
				array(
					'text' => 'Get Support',
					'url'  => 'https://github.com/ernilambar/ns-nepali-date/issues',
					'type' => 'secondary',
				),
			)
		);

		// Tab: nsnd_settings.
		$obj->add_tab(
			array(
				'id'    => 'nsnd_settings',
				'title' => esc_html__( 'Settings', 'ns-nepali-date' ),
			)
		);

		// Field: nsnd_language.
		$obj->add_field(
			'nsnd_settings',
			array(
				'id'      => 'nsnd_language',
				'type'    => 'radio',
				'title'   => esc_html__( 'Display Language', 'ns-nepali-date' ),
				'default' => 'np',
				'layout'  => 'horizontal',
				'choices' => array(
					'np' => esc_html__( 'Nepali', 'ns-nepali-date' ),
					'en' => esc_html__( 'English', 'ns-nepali-date' ),
				),
			)
		);

		// Field: nsnd_format.
		$obj->add_field(
			'nsnd_settings',
			array(
				'id'      => 'nsnd_format',
				'type'    => 'text',
				'title'   => esc_html__( 'Date Format', 'ns-nepali-date' ),
				'default' => 'd F Y',
				'class'   => 'field-nsnd_format',
			)
		);

		$obj->set_sidebar(
			array(
				'render_callback' => array( $this, 'render_sidebar' ),
			)
		);

		$obj->run();
	}

	/**
	 * Render admin sidebar.
	 *
	 * @since 1.0.0
	 *
	 * @param Welcom $welcome_object Welcome object.
	 */
	public function render_sidebar( $welcome_object ) {
		$welcome_object->render_sidebar_box(
			array(
				'title'   => 'Help &amp; Support',
				'icon'    => 'dashicons-editor-help',
				'content' => '<h4>Questions, bugs or great ideas?</h4>
				<p><a href="https://github.com/ernilambar/ns-nepali-date/issues" target="_blank">Create issue in the repo</a></p>',
			),
			$welcome_object
		);

		$welcome_object->render_sidebar_box(
			array(
				'title'   => 'Recent Blog Posts',
				'content' => '<div id="nsnd-posts-app"></div>',
			),
			$welcome_object
		);
	}
}
