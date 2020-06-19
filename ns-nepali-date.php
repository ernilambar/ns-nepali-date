<?php
/**
 * Plugin Name: NS Nepali Date
 * Plugin URI: https://github.com/ernilambar/ns-nepali-date
 * Description: Display post date in Nepali.
 * Version: 1.0.5
 * Author: Nilambar Sharma
 * Author URI: https://www.nilambar.net
 * Text Domain: ns-nepali-date
 * GitHub Plugin URI: ernilambar/ns-nepali-date
 * Release Asset: true
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package NS_Nepali_Date
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'NS_NEPALI_DATE_BASENAME', basename( dirname( __FILE__ ) ) );
define( 'NS_NEPALI_DATE_DIR', rtrim( plugin_dir_path( __FILE__ ), '/' ) );
define( 'NS_NEPALI_DATE_URL', rtrim( plugin_dir_url( __FILE__ ), '/' ) );

require_once NS_NEPALI_DATE_DIR . '/vendor/autoload.php';
require_once NS_NEPALI_DATE_DIR . '/inc/classes/class-ns-nepali-date.php';
require_once NS_NEPALI_DATE_DIR . '/inc/classes/class-ns-nepali-date-admin.php';
require_once NS_NEPALI_DATE_DIR . '/inc/helpers/helpers.php';

register_activation_hook( __FILE__, array( 'NS_Nepali_Date', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'NS_Nepali_Date', 'deactivate' ) );

add_action( 'plugins_loaded', array( 'NS_Nepali_Date', 'get_instance' ) );
add_action( 'plugins_loaded', array( 'NS_Nepali_Date_Admin', 'get_instance' ) );
