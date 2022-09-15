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
				'menu_title'     => esc_html__( 'NS Nepali Date', 'ns-nepali-date' ),
				'capability'     => 'manage_options',
				'menu_slug'      => 'ns-nepali-date',
				'option_slug'    => 'nsnd_plugin_options',
				'top_level_menu' => false,
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
	 */
	public function render_sidebar() {
		?>
		<div class="sidebox">
			<h3 class="sidebox-heading">Help &amp; Support</h3>
			<div class="sidebox-content">
				<p><strong>Questions, bugs, or great ideas?</strong></p>
				<p><a href="https://github.com/ernilambar/ns-nepali-date/issues" target="_blank">Create issue in the repo</a></p>
			</div>
		</div><!-- .sidebox -->

		<div class="sidebox">
			<h3 class="sidebox-heading">Recent Blog Posts</h3>
			<div class="sidebox-content">
				<div class="ns-blog-list"></div>
			</div>
		</div><!-- .sidebox -->
		<?php
	}
}
