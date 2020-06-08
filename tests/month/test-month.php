<?php
/**
 * Class MonthTest
 *
 * @package NS_Nepali_Date
 */

/**
 * Month test case.
 */
class MonthTest extends WP_UnitTestCase {

	/**
	 * Test nepali month Baishakh.
	 *
	 * @since 1.0.0
	 */
	public function test_nepali_month_baishakh() {
		$month = ns_nepali_date_get_month_text( 1 );

		$this->assertEquals( 'Baishakh', $month );
	}

	/**
	 * Test english month Baishakh Devnagari.
	 *
	 * @since 1.0.0
	 */
	public function test_nepali_month_baishakh_devnagari() {
		$month = ns_nepali_date_get_month_text( 1, 'np' );

		$this->assertEquals( 'बैसाख', $month );
	}

	/**
	 * Test nepali month Chaitra.
	 *
	 * @since 1.0.0
	 */
	public function test_nepali_month_chaitra() {
		$month = ns_nepali_date_get_month_text( 12 );

		$this->assertEquals( 'Chaitra', $month );
	}

	/**
	 * Test nepali month Chaitra Devnagari.
	 *
	 * @since 1.0.0
	 */
	public function test_nepali_month_chaitra_devnagari() {
		$month = ns_nepali_date_get_month_text( 12, 'np' );

		$this->assertEquals( 'चैत्र', $month );
	}
}
