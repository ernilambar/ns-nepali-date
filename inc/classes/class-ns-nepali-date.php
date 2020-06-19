<?php
/**
 * Plugin public class
 *
 * @package NS_Nepali_Date
 */

use Nilambar\NepaliDate\NepaliDate;

/**
 * Plugin class.
 *
 * @since 1.0.0
 */
class NS_Nepali_Date {

	/**
	 * Plugin version.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	const VERSION = '1.0.5';

	/**
	 * Unique identifier.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	protected $plugin_slug = 'ns-nepali-date';

	/**
	 * Plugin default options.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	protected static $default_options = array();

	/**
	 * Plugin options.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	protected $options = array();

	/**
	 * Instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	private function __construct() {
		// Load plugin text domain.
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Activate plugin when new blog is added.
		add_action( 'wpmu_new_blog', array( $this, 'activate_new_site' ) );

		self::$default_options = array(
			'nsnd_language' => 'np',
			'nsnd_format'   => 'd F Y',
		);

		// Set default options.
		$this->set_default_options();

		// Get current options.
		$this->get_current_options();

		// Initialize custom hooks.
		add_action( 'init', array( $this, 'initialize_hooks' ) );
	}

	/**
	 * Initialize custom hooks.
	 *
	 * @since 1.0.0
	 */
	public function initialize_hooks() {
		if ( ! is_admin() ) {
			add_filter( 'get_the_date', array( $this, 'replace_date' ), 10, 3 );
			add_filter( 'get_the_time', array( $this, 'replace_date' ), 10, 3 );
		}
	}

	/**
	 * Customize date.
	 *
	 * @since 1.0.0
	 *
	 * @param string      $date    The formatted date.
	 * @param string      $format PHP date format.
	 * @param int|WP_Post $post   The post object or ID.
	 */
	public function replace_date( $date, $format, $post ) {
		$nd_object = new NepaliDate();

		$date_ymd = gmdate( 'Y-m-d', strtotime( $date ) );

		list( $year, $month, $day ) = explode( '-', $date_ymd );

		$date_details = $nd_object->getDetails( $year, $month, $day, 'ad', $this->options['nsnd_language'] );

		return $nd_object->getFormattedDate( $date_details, $this->options['nsnd_format'] );
	}

	/**
	 * Return the plugin slug.
	 *
	 * @since 1.0.0
	 *
	 * @return string Plugin slug.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

	/**
	 * Return an instance of the class.
	 *
	 * @since 1.0.0
	 *
	 * @return NS_Nepali_Date A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since 1.0.0
	 *
	 * @param boolean $network_wide Whether activated network wide or not.
	 */
	public static function activate( $network_wide ) {
		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide ) {

				// Get all blog ids.
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {
					switch_to_blog( $blog_id );
					self::single_activate();
				}

				restore_current_blog();
			} else {
				self::single_activate();
			}
		} else {
			self::single_activate();
		}
	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since 1.0.0
	 *
	 * @param boolean $network_wide Whether deactivated network wide or not.
	 */
	public static function deactivate( $network_wide ) {
		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide ) {

				// Get all blog ids.
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {
					switch_to_blog( $blog_id );
					self::single_deactivate();
				}

				restore_current_blog();
			} else {
				self::single_deactivate();
			}
		} else {
			self::single_deactivate();
		}
	}

	/**
	 * Fired when a new site is activated with a WPMU environment.
	 *
	 * @since 1.0.0
	 *
	 * @param int $blog_id ID of the new blog.
	 */
	public function activate_new_site( $blog_id ) {
		if ( 1 !== did_action( 'wpmu_new_blog' ) ) {
			return;
		}

		switch_to_blog( $blog_id );
		self::single_activate();
		restore_current_blog();
	}

	/**
	 * Get all active blog ids.
	 *
	 * @since 1.0.0
	 *
	 * @return array|false The blog ids, false if no matches.
	 */
	private static function get_blog_ids() {
		global $wpdb;

		$ids = array();

		$output = $wpdb->get_results( "SELECT blog_id FROM $wpdb->blogs WHERE archived = '0' AND spam = '0' AND deleted = '0'", ARRAY_A );

		if ( $output ) {
			$ids = wp_list_pluck( $output, 'blog_id' );
		}

		return $ids;
	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since 1.0.0
	 */
	private static function single_activate() {
		$option_name = 'nsnd_plugin_options';
		update_option( $option_name, self::$default_options );
	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since 1.0.0
	 */
	private static function single_deactivate() {
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since 1.0.0
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( $this->plugin_slug );
	}

	/**
	 * Get plugin option details.
	 *
	 * @since 1.0.0
	 *
	 * @return array Plugin options.
	 */
	public function get_plugin_options_array() {
		return $this->options;
	}

	/**
	 * Get version.
	 *
	 * @since 1.0.0
	 *
	 * @return string Version string.
	 */
	public function get_version() {
		return self::VERSION;
	}

	/**
	 * Fetch plugin options.
	 *
	 * @since 1.0.0
	 */
	private function get_current_options() {
		$this->options = array_merge( self::$default_options, (array) get_option( 'nsnd_plugin_options', array() ) );
	}

	/**
	 * Set default plugin options.
	 *
	 * @since 1.0.0
	 */
	private function set_default_options() {
		if ( ! get_option( 'nsnd_plugin_options' ) ) {
			update_option( 'nsnd_plugin_options', self::$default_options );
		}
	}

	/**
	 * Remove plugin options.
	 *
	 * @since 1.0.0
	 */
	private function remove_plugin_options() {
		delete_option( 'nsnd_plugin_options' );
	}
}
