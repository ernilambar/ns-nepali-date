<?php
/**
 * Admin
 *
 * @package NS_Nepali_Date
 */

?>

<div class="wrap">
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

	<div id="poststuff">

		<div id="post-body" class="metabox-holder columns-2">

			<div id="post-body-content">

				<div class="meta-box-sortables ui-sortable">

					<div class="postbox">

						<div class="inside">

							<form action="options.php" method="post">
								<?php settings_fields( 'nsnd-plugin-options-group' ); ?>
								<?php do_settings_sections( 'ns-nepali-date-main' ); ?>
								<?php submit_button( esc_html__( 'Save Changes', 'ns-nepali-date' ) ); ?>
							</form>

						</div><!-- .inside -->

					</div><!-- .postbox -->

				</div><!-- .meta-box-sortables .ui-sortable -->

			</div><!-- post-body-content -->

			<div id="postbox-container-1" class="postbox-container">

				<?php require_once NS_NEPALI_DATE_DIR . '/inc/views/admin-right.php'; ?>

			</div><!-- #postbox-container-1 .postbox-container -->

		</div><!-- #post-body .metabox-holder .columns-2 -->

	</div><!-- #poststuff -->
</div><!-- .wrap -->
