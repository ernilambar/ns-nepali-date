<?php
/**
 * Plugin Name: NS Nepali Date
 * Plugin URI: https://github.com/ernilambar/ns-nepali-date/
 * Description: Display post date in Nepali.
 * Version: 1.0.10
 * Author: Nilambar Sharma
 * Author URI: https://www.nilambar.net/
 * Text Domain: ns-nepali-date
 * GitHub Plugin URI: ernilambar/ns-nepali-date
 * Primary Branch: main
 * Release Asset: true
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package NSNepaliDate
 */

namespace NSNepaliDate;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'NS_NEPALI_DATE_VERSION', '1.0.10' );
define( 'NS_NEPALI_DATE_SLUG', 'ns-nepali-date' );
define( 'NS_NEPALI_DATE_BASENAME', basename( dirname( __FILE__ ) ) );
define( 'NS_NEPALI_DATE_BASE_FILENAME', plugin_basename( __FILE__ ) );
define( 'NS_NEPALI_DATE_DIR', rtrim( plugin_dir_path( __FILE__ ), '/' ) );
define( 'NS_NEPALI_DATE_URL', rtrim( plugin_dir_url( __FILE__ ), '/' ) );

if ( ! defined( 'OPTIONER_DIR' ) ) {
	define( 'OPTIONER_DIR', NS_NEPALI_DATE_DIR . '/vendor/ernilambar/optioner' );
}

if ( ! defined( 'OPTIONER_URL' ) ) {
	define( 'OPTIONER_URL', NS_NEPALI_DATE_URL . '/vendor/ernilambar/optioner' );
}

// Include autoload.
if ( file_exists( NS_NEPALI_DATE_DIR . '/vendor/autoload.php' ) ) {
	require_once NS_NEPALI_DATE_DIR . '/vendor/autoload.php';
	require_once NS_NEPALI_DATE_DIR . '/vendor/ernilambar/optioner/optioner.php';
}

if ( class_exists( 'NSNepaliDate\Init' ) ) {
	\NSNepaliDate\Init::register_services();
}
