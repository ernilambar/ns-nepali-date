<?php
/**
 * Class
 *
 * @package NS_Nepali_Date
 */

/**
 * Format.
 */
class FormatTest extends WP_UnitTestCase {

	/**
	 * Test format english language.
	 *
	 * @since 1.0.0
	 */
	public function test_format_english_language() {
		$cal_object = new Nepali_Calendar();

		$year  = 2020;
		$month = 1;
		$day   = 1;

		$new_date = $cal_object->eng_to_nep( $year, $month, $day );

		$details = ns_nepali_date_get_date_details( $new_date, 'en' );

		$formatted_date = ns_nepali_date_get_formatted_date( $details, 'Y-m-d' );
		$this->assertEquals( '2076-09-16', $formatted_date );

		$formatted_date = ns_nepali_date_get_formatted_date( $details, 'd F, Y' );
		$this->assertEquals( '16 Poush, 2076', $formatted_date );

		$formatted_date = ns_nepali_date_get_formatted_date( $details, 'Y F d, l' );
		$this->assertEquals( '2076 Poush 16, Budhabar', $formatted_date );

		$formatted_date = ns_nepali_date_get_formatted_date( $details, 'D, d F' );
		$this->assertEquals( 'Budha, 16 Poush', $formatted_date );
	}

	/**
	 * Test format nepali language.
	 *
	 * @since 1.0.0
	 */
	public function test_format_nepali_language() {
		$cal_object = new Nepali_Calendar();

		$year  = 2020;
		$month = 1;
		$day   = 1;

		$new_date = $cal_object->eng_to_nep( $year, $month, $day );

		$details = ns_nepali_date_get_date_details( $new_date, 'np' );

		$formatted_date = ns_nepali_date_get_formatted_date( $details, 'Y-m-d' );
		$this->assertEquals( '२०७६-०९-१६', $formatted_date );

		$formatted_date = ns_nepali_date_get_formatted_date( $details, 'd F, Y' );
		$this->assertEquals( '१६ पुष, २०७६', $formatted_date );

		$formatted_date = ns_nepali_date_get_formatted_date( $details, 'Y F d, l' );
		$this->assertEquals( '२०७६ पुष १६, बुधबार', $formatted_date );

		$formatted_date = ns_nepali_date_get_formatted_date( $details, 'D, d F' );
		$this->assertEquals( 'बुध, १६ पुष', $formatted_date );
	}
}
