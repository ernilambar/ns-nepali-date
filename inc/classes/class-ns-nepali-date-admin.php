<?php
/**
 * Plugin admin class
 *
 * @package NS_Nepali_Date
 */

use Nilambar\Optioner\Optioner;

/**
 * Plugin admin class.
 *
 * @since 1.0.0
 */
class NS_Nepali_Date_Admin {

	/**
	 * Instance of this class.
	 *
	 * @since .0.0
	 *
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Plugin options.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	protected $options = array();

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	private function __construct() {
		$plugin            = NS_Nepali_Date::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();
		$this->options     = $plugin->get_plugin_options_array();
		$this->version     = $plugin->get_version();

		// Initialize custom hooks.
		add_action( 'init', array( $this, 'initialize_hooks' ) );
	}

	/**
	 * Initialize custom hooks.
	 *
	 * @since 1.0.0
	 */
	public function initialize_hooks() {
		// Add the options page and menu item.
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );

		// Add an action link pointing to the options page.
		$plugin_basename = NS_NEPALI_DATE_BASENAME . '/' . $this->plugin_slug . '.php';
		add_filter( 'plugin_action_links_' . $plugin_basename, array( $this, 'add_action_links' ) );

		// Register plugin settings.
		add_action( 'admin_init', array( $this, 'plugin_register_settings' ) );

		// Load assets.
		add_action( 'admin_enqueue_scripts', array( $this, 'load_assets' ) );

		$obj = new Optioner();

		$obj->set_page(
			array(
				'page_title'     => esc_html__( 'NS Nepali Date', 'ns-nepali-date' ),
				'menu_title'     => esc_html__( 'NS Nepali Date', 'ns-nepali-date' ),
				'capability'     => 'manage_options',
				'menu_slug'      => 'nsnd',
				'option_slug'    => 'nsnd_plugin_options',
				'top_level_menu' => true,
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
				'type'    => 'select',
				'title'   => esc_html__( 'Display Language', 'ns-nepali-date' ),
				'default' => 'np',
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

		// Run now.
		$obj->run();

		add_action( 'optioner_field_bottom_text', array( $this, 'customize_format' ), 10, 3 );
	}

	public function customize_format($field_id, $page_slug, $args ) {
		if ( 'nsnd_format' !== $field_id  ) {
			return;
		}

		$format_list = ns_nepali_date_get_example_formats();
		?>

		<?php if ( ! empty( $format_list ) ) : ?>
			<div class="example-formats">
				<div class="format-list">
					<span class="title"><?php esc_html_e( 'Examples:', 'ns-nepali-date' ); ?></span>
					<?php foreach ( $format_list as $item ) : ?>
						<a href="#" data-format="<?php echo esc_attr( $item['format'] ); ?>" title="<?php echo esc_attr( $item['format'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
					<?php endforeach; ?>
				</div><!-- .format-list -->
			</div><!-- .example-formats -->
		<?php endif; ?>

		<div class="format-reference">
			<a href="#" class="btn-toggle-reference">Reference</a>
			<div class="format-reference-content">
				<table>
					<tr class="heading">
						<td>Symbol</td>
						<td>Definition</td>
						<td>Example</td>
					</tr>
					<tr>
						<td>Y</td>
						<td>Year in 4 digits</td>
						<td>२०७७</td>
					</tr>
					<tr>
						<td>y</td>
						<td>Year in 2 digits</td>
						<td>७७</td>
					</tr>
					<tr>
						<td>j</td>
						<td>Day number</td>
						<td>८</td>
					</tr>
					<tr>
						<td>d</td>
						<td>Day number with leading zero</td>
						<td>०८</td>
					</tr>
					<tr>
						<td>F</td>
						<td>Month text</td>
						<td>जेठ</td>
					</tr>
					<tr>
						<td>n</td>
						<td>Month number</td>
						<td>२</td>
					</tr>
					<tr>
						<td>m</td>
						<td>Month number with leading zero</td>
						<td>०२</td>
					</tr>
					<tr>
						<td>l</td>
						<td>Week day full</td>
						<td>आइतबार</td>
					</tr>
					<tr>
						<td>D</td>
						<td>Week day short</td>
						<td>आइत</td>
					</tr>
				</table>
			</div><!-- .format-reference-content -->
		</div><!-- .format-reference -->
		<?php
	}

	/**
	 * Add admin menu.
	 *
	 * @since 1.0.0
	 */
	public function add_admin_menu() {
		$this->plugin_screen_hook_suffix = add_options_page( esc_html__( 'NS Nepali Date', 'ns-nepali-date' ), __( 'NS Nepali Date', 'ns-nepali-date' ), 'manage_options', 'ns-nepali-date', array( $this, 'display_plugin_admin_page' ) );
	}

	/**
	 * Register plugin settings.
	 *
	 * @since 1.0.0
	 */
	public function plugin_register_settings() {
		register_setting( 'nsnd-plugin-options-group', 'nsnd_plugin_options', array( $this, 'validate_options' ) );

		add_settings_section( 'main_settings', esc_html__( 'Plugin Settings', 'ns-nepali-date' ), array( $this, 'render_plugin_section_text_callback' ), 'ns-nepali-date-main' );

		add_settings_field( 'nsnd_language', esc_html__( 'Display Language', 'ns-nepali-date' ), array( $this, 'nsnd_language_callback' ), 'ns-nepali-date-main', 'main_settings' );

		add_settings_field( 'nsnd_format', esc_html__( 'Date Format', 'ns-nepali-date' ), array( $this, 'nsnd_format_callback' ), 'ns-nepali-date-main', 'main_settings' );
	}

	/**
	 * Render section text.
	 *
	 * @since 1.0.0
	 */
	public function render_plugin_section_text_callback() {
	}

	/**
	 * Validate plugin options.
	 *
	 * @since 1.0.0
	 *
	 * @param array $input Raw input.
	 * @return array Sanitized values.
	 */
	public function validate_options( $input ) {
		$input['nsnd_language'] = sanitize_text_field( $input['nsnd_language'] );
		$input['nsnd_format']   = sanitize_text_field( $input['nsnd_format'] );

		return $input;
	}

	/**
	 * Render field.
	 *
	 * @since 1.0.0
	 */
	public function nsnd_language_callback() {
		?>
		<div class="field-nsnd-language">
			<select name="nsnd_plugin_options[nsnd_language]" class="input-nsnd-language">
				<option value="np" <?php selected( 'np', $this->options['nsnd_language'] ); ?>><?php esc_html_e( 'Nepali', 'ns-nepali-date' ); ?></option>
				<option value="en" <?php selected( 'en', $this->options['nsnd_language'] ); ?>><?php esc_html_e( 'English', 'ns-nepali-date' ); ?></option>
			</select>
		</div><!-- .field-nsnd-language -->
		<?php
	}

	/**
	 * Render field.
	 *
	 * @since 1.0.0
	 */
	public function nsnd_format_callback() {
		$format_list = ns_nepali_date_get_example_formats();
		?>
		<div class="field-nsnd-format">
			<p><input type="text" name="nsnd_plugin_options[nsnd_format]" value="<?php echo esc_attr( $this->options['nsnd_format'] ); ?>" class="input-nsnd-format" /></p>
			<?php if ( ! empty( $format_list ) ) : ?>
				<div class="example-formats">
					<div class="format-list">
						<span class="title"><?php esc_html_e( 'Examples:', 'ns-nepali-date' ); ?></span>
						<?php foreach ( $format_list as $item ) : ?>
							<a href="#" data-format="<?php echo esc_attr( $item['format'] ); ?>" title="<?php echo esc_attr( $item['format'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
						<?php endforeach; ?>
					</div><!-- .format-list -->
				</div><!-- .example-formats -->
			<?php endif; ?>
			<div class="format-reference">
				<a href="#" class="btn-toggle-reference">Reference</a>
				<div class="format-reference-content">
					<table>
						<tr class="heading">
							<td>Symbol</td>
							<td>Definition</td>
							<td>Example</td>
						</tr>
						<tr>
							<td>Y</td>
							<td>Year in 4 digits</td>
							<td>२०७७</td>
						</tr>
						<tr>
							<td>y</td>
							<td>Year in 2 digits</td>
							<td>७७</td>
						</tr>
						<tr>
							<td>j</td>
							<td>Day number</td>
							<td>८</td>
						</tr>
						<tr>
							<td>d</td>
							<td>Day number with leading zero</td>
							<td>०८</td>
						</tr>
						<tr>
							<td>F</td>
							<td>Month text</td>
							<td>जेठ</td>
						</tr>
						<tr>
							<td>n</td>
							<td>Month number</td>
							<td>२</td>
						</tr>
						<tr>
							<td>m</td>
							<td>Month number with leading zero</td>
							<td>०२</td>
						</tr>
						<tr>
							<td>l</td>
							<td>Week day full</td>
							<td>आइतबार</td>
						</tr>
						<tr>
							<td>D</td>
							<td>Week day short</td>
							<td>आइत</td>
						</tr>
					</table>
				</div><!-- .format-reference-content -->
			</div><!-- .format-reference -->
		</div><!-- .field-nsnd-format -->
		<?php
	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since 1.0.0
	 */
	public function display_plugin_admin_page() {
		// Check that the user is allowed to update options.
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( 'You do not have sufficient permissions to access this page.' );
		}

		require_once NS_NEPALI_DATE_DIR . '/inc/views/admin.php';
	}

	/**
	 * Return an instance of the class.
	 *
	 * @since 1.0.0
	 *
	 * @return NS_Nepali_Date_Admin A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since 1.0.0
	 *
	 * @param array $links Links.
	 * @return array Modified Links.
	 */
	public function add_action_links( $links ) {
		return array_merge(
			array(
				'settings' => '<a href="' . esc_url( admin_url( 'options-general.php?page=' . $this->plugin_slug ) ) . '">' . esc_html__( 'Settings', 'ns-nepali-date' ) . '</a>',
			),
			$links
		);
	}

	/**
	 * Load assets.
	 *
	 * @since 1.0.0
	 *
	 * @param array $hook Hook name.
	 */
	public function load_assets( $hook ) {
		if ( 'settings_page_ns-nepali-date' === $hook ) {
			wp_enqueue_script( 'ns-nepali-date-admin', NS_NEPALI_DATE_URL . '/assets/js/admin.js', array(), $this->version, false );
			wp_enqueue_style( 'ns-nepali-date-admin', NS_NEPALI_DATE_URL . '/assets/css/admin.css', array(), $this->version );
		}
	}
}
