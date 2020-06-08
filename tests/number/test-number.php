<?php
/**
 * Class NumberTest
 *
 * @package NS_Nepali_Date
 */

/**
 * Number test case.
 */
class NumberTest extends WP_UnitTestCase {

	/**
	 * Test nepali number single digit.
	 *
	 * @since 1.0.0
	 */
	public function test_nepali_number_single_digit() {
		$out = ns_nepali_date_get_nepali_number( 1 );

		$this->assertEquals( '१', $out );
	}

	/**
	 * Test nepali number double digit.
	 *
	 * @since 1.0.0
	 */
	public function test_nepali_number_double_digit() {
		$out = ns_nepali_date_get_nepali_number( 25 );

		$this->assertEquals( '२५', $out );
	}

	/**
	 * Test nepali number single digit with padding 2.
	 *
	 * @since 1.0.0
	 */
	public function test_nepali_number_single_digit_with_padding_2() {
		$out = ns_nepali_date_get_nepali_number( 1, true );

		$this->assertEquals( '०१', $out );
	}

	/**
	 * Test nepali number single digit with padding 4.
	 *
	 * @since 1.0.0
	 */
	public function test_nepali_number_single_digit_with_padding_4() {
		$out = ns_nepali_date_get_nepali_number( 1, true, 4 );

		$this->assertEquals( '०००१', $out );
	}


}
