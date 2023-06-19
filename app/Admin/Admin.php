<?php
/**
 * Admin
 *
 * @package NSNepaliDate
 */

namespace NSNepaliDate\Admin;

use NSNepaliDate\Common\Helper;

/**
 * Admin class.
 *
 * @since 1.0.0
 */
class Admin {

	/**
	 * Register.
	 *
	 * @since 1.0.0
	 */
	public function register() {
		add_filter( 'plugin_action_links_' . NS_NEPALI_DATE_BASE_FILENAME, array( $this, 'customize_plugin_action_links' ) );
		add_action( 'optioner_field_bottom_text', array( $this, 'customize_format' ), 10, 1 );
		add_action( 'admin_enqueue_scripts', array( $this, 'load_assets' ) );
		add_action( 'wp_ajax_nopriv_nsnd_nsbl_get_posts', array( $this, 'get_posts_ajax_callback' ) );
		add_action( 'wp_ajax_nsnd_nsbl_get_posts', array( $this, 'get_posts_ajax_callback' ) );
	}

	/**
	 * Customize plugin action links.
	 *
	 * @since 1.0.0
	 *
	 * @param array $actions Action links.
	 * @return array Modified action links.
	 */
	public function customize_plugin_action_links( $actions ) {
		$url = add_query_arg(
			array(
				'page' => NS_NEPALI_DATE_SLUG,
			),
			admin_url( 'options-general.php' )
		);

		$actions = array_merge(
			array(
				'settings' => '<a href="' . esc_url( $url ) . '">' . esc_html__( 'Settings', 'ns-nepali-date' ) . '</a>',
			),
			$actions
		);

		return $actions;
	}

	/**
	 * Customize format field.
	 *
	 * @since 1.0.0
	 *
	 * @param string $field_id  Field ID.
	 */
	public function customize_format( $field_id ) {
		if ( 'nsnd_format' !== $field_id ) {
			return;
		}

		$format_list = Helper::get_example_formats();
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
	 * Load assets.
	 *
	 * @since 1.0.0
	 *
	 * @param string $hook Hook name.
	 */
	public function load_assets( $hook ) {
		if ( 'settings_page_ns-nepali-date' !== $hook ) {
			return;
		}

		// Admin.
		$deps_file = NS_NEPALI_DATE_DIR . '/build/admin.asset.php';

		$dependency = array();

		if ( file_exists( $deps_file ) ) {
			$deps_file  = require $deps_file;
			$dependency = $deps_file['dependencies'];
			$version    = $deps_file['version'];
		}

		wp_enqueue_style( 'ns-nepali-date-admin', NS_NEPALI_DATE_URL . '/build/admin.css', array(), $version );

		wp_enqueue_script( 'ns-nepali-date-admin', NS_NEPALI_DATE_URL . '/build/admin.js', $dependency, $version, true );

		// Posts.
		$deps_file = NS_NEPALI_DATE_DIR . '/build/posts.asset.php';

		$dependency = array();

		if ( file_exists( $deps_file ) ) {
			$deps_file  = require $deps_file;
			$dependency = $deps_file['dependencies'];
			$version    = $deps_file['version'];
		}

		$data = array(
			'ajax_url'     => admin_url( 'admin-ajax.php' ),
			'posts_action' => 'nsnd_nsbl_get_posts',
		);

		wp_enqueue_script( 'ns-nepali-date-posts', NS_NEPALI_DATE_URL . '/build/posts.js', $dependency, $version, true );
		wp_localize_script( 'ns-nepali-date-posts', 'NSND_POSTS', $data );
	}

	/**
	 * AJAX callback for blog posts.
	 *
	 * @since 1.0.0
	 */
	public function get_posts_ajax_callback() {
		$output = array();

		$posts = Helper::get_blog_feed_items();

		if ( ! empty( $posts ) ) {
			$output = $posts;
		}

		if ( ! empty( $output ) ) {
			wp_send_json_success( $output, 200 );
		} else {
			wp_send_json_error( $output, 404 );
		}
	}
}
