<?php
/**
 * Class DayTest
 *
 * @package Ns_Nepali_Date
 */

/**
 * Day test case.
 */
class DayTest extends WP_UnitTestCase {

	/**
	 * Test nepali day aaitabar.
	 *
	 * @since 1.0.0
	 */
	public function test_nepali_day_aaitabar() {
		$out = ns_nepali_date_get_nepali_day_text( 1, 'l' );

		$this->assertEquals( 'आइतबार', $out );
	}

	/**
	 * Test english day aaitabar.
	 *
	 * @since 1.0.0
	 */
	public function test_english_day_aaitabar() {
		$out = ns_nepali_date_get_english_day_text( 1, 'l' );

		$this->assertEquals( 'Aaitabar', $out );
	}

	/**
	 * Test nepali day aaitabar short.
	 *
	 * @since 1.0.0
	 */
	public function test_nepali_day_aaitabar_short() {
		$out = ns_nepali_date_get_nepali_day_text( 1, 'D' );

		$this->assertEquals( 'आइत', $out );
	}

	/**
	 * Test english day aaitabar short.
	 *
	 * @since 1.0.0
	 */
	public function test_english_day_aaitabar_short() {
		$out = ns_nepali_date_get_english_day_text( 1, 'D' );

		$this->assertEquals( 'Aaita', $out );
	}
}
