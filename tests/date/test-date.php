<?php
/**
 * Class DateTest
 *
 * @package NS_Nepali_Date
 */

/**
 * Date test case.
 */
class DateTest extends WP_UnitTestCase {

	/**
	 * Test date details english language.
	 *
	 * @since 1.0.0
	 */
	public function test_date_details_english_language() {
		$cal_object = new Nepali_Calendar();

		$year  = 2020;
		$month = 1;
		$day   = 1;

		$new_date = $cal_object->eng_to_nep( $year, $month, $day );

		$valid = array(
			'Y' => '2076',
			'y' => '76',
			'j' => '16',
			'd' => '16',
			'F' => 'Poush',
			'n' => '9',
			'm' => '09',
			'l' => 'Budhabar',
			'D' => 'Budha',
		);

		$out = ns_nepali_date_get_date_details( $new_date, 'en' );

		$this->assertEquals( $valid['Y'], $out['Y'] );
		$this->assertEquals( $valid['y'], $out['y'] );
		$this->assertEquals( $valid['j'], $out['j'] );
		$this->assertEquals( $valid['d'], $out['d'] );
		$this->assertEquals( $valid['F'], $out['F'] );
		$this->assertEquals( $valid['n'], $out['n'] );
		$this->assertEquals( $valid['m'], $out['m'] );
		$this->assertEquals( $valid['l'], $out['l'] );
		$this->assertEquals( $valid['D'], $out['D'] );
	}

	/**
	 * Test date details nepali language.
	 *
	 * @since 1.0.0
	 */
	public function test_date_details_nepali_language() {
		$cal_object = new Nepali_Calendar();

		$year  = 2020;
		$month = 1;
		$day   = 1;

		$new_date = $cal_object->eng_to_nep( $year, $month, $day );

		$valid = array(
			'Y' => '२०७६',
			'y' => '७६',
			'j' => '१६',
			'd' => '१६',
			'F' => 'पुष',
			'n' => '९',
			'm' => '०९',
			'l' => 'बुधबार',
			'D' => 'बुध',
		);

		$out = ns_nepali_date_get_date_details( $new_date, 'np' );

		$this->assertEquals( $valid['Y'], $out['Y'] );
		$this->assertEquals( $valid['y'], $out['y'] );
		$this->assertEquals( $valid['j'], $out['j'] );
		$this->assertEquals( $valid['d'], $out['d'] );
		$this->assertEquals( $valid['F'], $out['F'] );
		$this->assertEquals( $valid['n'], $out['n'] );
		$this->assertEquals( $valid['m'], $out['m'] );
		$this->assertEquals( $valid['l'], $out['l'] );
		$this->assertEquals( $valid['D'], $out['D'] );
	}
}
