<?php
/**
 * Plugin Name: NS Nepali Date
 * Plugin URI: https://github.com/ernilambar/ns-nepali-date/
 * Description: Display post date in Nepali.
 * Version: 1.0.22
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Author: Nilambar Sharma
 * Author URI: https://www.nilambar.net/
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/old-licenses/gpl-2.0.txt
 * Text Domain: ns-nepali-date
 *
 * @package NSNepaliDate
 */

namespace NSNepaliDate;

use Nilambar\Gitvise\Updater;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'NS_NEPALI_DATE_VERSION', '1.0.22' );
define( 'NS_NEPALI_DATE_SLUG', 'ns-nepali-date' );
define( 'NS_NEPALI_DATE_BASENAME', basename( __DIR__ ) );
define( 'NS_NEPALI_DATE_BASE_FILENAME', plugin_basename( __FILE__ ) );
define( 'NS_NEPALI_DATE_DIR', rtrim( plugin_dir_path( __FILE__ ), '/' ) );
define( 'NS_NEPALI_DATE_URL', rtrim( plugin_dir_url( __FILE__ ), '/' ) );

// Include autoload.
if ( file_exists( NS_NEPALI_DATE_DIR . '/vendor/autoload.php' ) ) {
	require_once NS_NEPALI_DATE_DIR . '/vendor/autoload.php';
	require_once NS_NEPALI_DATE_DIR . '/vendor/ernilambar/optioner/optioner.php';
	require_once NS_NEPALI_DATE_DIR . '/vendor/ernilambar/gitvise/init.php';
	require_once NS_NEPALI_DATE_DIR . '/vendor/ernilambar/vitbolt/init.php';
}

if ( class_exists( 'NSNepaliDate\Init' ) ) {
	Init::register_services();
}

$updater = new Updater( 'ernilambar/ns-nepali-date', __FILE__, NS_NEPALI_DATE_SLUG );
$updater->init();
