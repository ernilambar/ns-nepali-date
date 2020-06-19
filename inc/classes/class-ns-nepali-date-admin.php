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
	 * @since 1.0.0
	 *
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * Menu slug.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	protected $menu_slug = 'ns-nepali-date';

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
		// Add an action link pointing to the options page.
		$plugin_basename = NS_NEPALI_DATE_BASENAME . '/' . $this->plugin_slug . '.php';
		add_filter( 'plugin_action_links_' . $plugin_basename, array( $this, 'add_action_links' ) );

		// Load assets.
		add_action( 'admin_enqueue_scripts', array( $this, 'load_assets' ) );

		$obj = new Optioner();

		$obj->set_page(
			array(
				'page_title'     => esc_html__( 'NS Nepali Date', 'ns-nepali-date' ),
				'menu_title'     => esc_html__( 'NS Nepali Date', 'ns-nepali-date' ),
				'capability'     => 'manage_options',
				'menu_slug'      => $this->menu_slug,
				'option_slug'    => 'nsnd_plugin_options',
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

		// Sidebar.
		$obj->set_sidebar( array( $this, 'render_sidebar' ) );

		// Run now.
		$obj->run();

		add_action( 'optioner_field_bottom_text', array( $this, 'customize_format' ), 10, 3 );
	}

	public function customize_format( $field_id, $page_slug, $args ) {
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

	/**
	 * Render sidebar.
	 *
	 * @since 1.0.0
	 */
	public function render_sidebar() {
		?>
		<div class="sidebox">
			<h3 class="box-heading">Help &amp; Support</h3>
			<div class="box-content">
				<ul>
					<li><strong>Questions, bugs, or great ideas?</strong></li>
					<li><a href="https://github.com/ernilambar/ns-nepali-date/issues" target="_blank">Create issue in the repo</a></li>
				</ul>
			</div>
		</div><!-- .sidebox -->
		<div class="sidebox">
			<h3 class="box-heading">My Blog</h3>
			<div class="box-content">
				<?php
				$rss = fetch_feed( 'https://www.nilambar.net/category/wordpress/feed' );

				$maxitems = 0;

				$rss_items = array();

				if ( ! is_wp_error( $rss ) ) {
					$maxitems  = $rss->get_item_quantity( 5 );
					$rss_items = $rss->get_items( 0, $maxitems );
				}
				?>

				<?php if ( ! empty( $rss_items ) ) : ?>

					<ul>
						<?php foreach ( $rss_items as $item ) : ?>
							<li><a href="<?php echo esc_url( $item->get_permalink() ); ?>" target="_blank"><?php echo esc_html( $item->get_title() ); ?></a></li>
						<?php endforeach; ?>
					</ul>

				<?php endif; ?>
			</div>
		</div><!-- .sidebox -->
		<?php
	}
}
