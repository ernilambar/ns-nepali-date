<?php
/**
 * Hooks
 *
 * @package NSNepaliDate
 */

namespace NSNepaliDate\Hooks;

use Nilambar\NepaliDate\NepaliDate;
use NSNepaliDate\Core\Option;

/**
 * Hooks class.
 *
 * @since 1.0.0
 */
class Hooks {

	/**
	 * Register.
	 *
	 * @since 1.0.0
	 */
	public function register() {
		add_action( 'init', array( $this, 'hooks' ) );
	}

	/**
	 * Initialize hooks.
	 *
	 * @since 1.0.0
	 */
	public function hooks() {
		if ( ! is_admin() ) {
			add_filter( 'get_the_date', array( $this, 'replace_date' ), 10, 1 );
			add_filter( 'get_the_time', array( $this, 'replace_date' ), 10, 1 );
		}
	}

	/**
	 * Customize date.
	 *
	 * @since 1.0.0
	 *
	 * @param string $date The formatted date.
	 */
	public function replace_date( $date ) {
		$nd_object = new NepaliDate();

		$nsnd_language = Option::get( 'nsnd_language' );
		$nsnd_format   = Option::get( 'nsnd_format' );

		$date_ymd = gmdate( 'Y-m-d', strtotime( $date ) );

		list( $year, $month, $day ) = explode( '-', $date_ymd );

		$date_details = $nd_object->getDetails( $year, $month, $day, 'ad', $nsnd_language );

		return $nd_object->getFormattedDate( $date_details, $nsnd_format );
	}
}
