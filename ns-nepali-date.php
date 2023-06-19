<?php
/**
 * Plugin Name: NS Nepali Date
 * Plugin URI: https://github.com/ernilambar/ns-nepali-date/
 * Description: Display post date in Nepali.
 * Version: 1.0.18
 * Author: Nilambar Sharma
 * Author URI: https://www.nilambar.net/
 * Text Domain: ns-nepali-date
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

define( 'NS_NEPALI_DATE_VERSION', '1.0.18' );
define( 'NS_NEPALI_DATE_SLUG', 'ns-nepali-date' );
define( 'NS_NEPALI_DATE_BASENAME', basename( __DIR__ ) );
define( 'NS_NEPALI_DATE_BASE_FILENAME', plugin_basename( __FILE__ ) );
define( 'NS_NEPALI_DATE_DIR', rtrim( plugin_dir_path( __FILE__ ), '/' ) );
define( 'NS_NEPALI_DATE_URL', rtrim( plugin_dir_url( __FILE__ ), '/' ) );

// Include autoload.
if ( file_exists( NS_NEPALI_DATE_DIR . '/vendor/autoload.php' ) ) {
	require_once NS_NEPALI_DATE_DIR . '/vendor/autoload.php';
	require_once NS_NEPALI_DATE_DIR . '/vendor/ernilambar/optioner/optioner.php';
	require_once NS_NEPALI_DATE_DIR . '/vendor/yahnis-elsts/plugin-update-checker/plugin-update-checker.php';
}

if ( class_exists( 'NSNepaliDate\Init' ) ) {
	\NSNepaliDate\Init::register_services();
}

$nsnd_update_checker = \YahnisElsts\PluginUpdateChecker\v5\PucFactory::buildUpdateChecker( 'https://github.com/ernilambar/ns-nepali-date', __FILE__, NS_NEPALI_DATE_SLUG );
$nsnd_update_checker->getVcsApi()->enableReleaseAssets();
