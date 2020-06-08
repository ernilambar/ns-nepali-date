<?php
/**
 * Class
 *
 * @package NS_Nepali_Date
 */

/**
 * Converter.
 */
class ConverterTest extends WP_UnitTestCase {

	/**
	 * Test converter english to nepali.
	 *
	 * @since 1.0.0
	 */
	public function test_converter_english_to_nepali() {
		$cal_object = new Nepali_Calendar();

		$year  = 2020;
		$month = 1;
		$day   = 1;

		$out = $cal_object->eng_to_nep( $year, $month, $day );

		$this->assertEquals( '2076', $out['year'] );
		$this->assertEquals( '9', $out['month'] );
		$this->assertEquals( '16', $out['date'] );
		$this->assertEquals( 'Wednesday', $out['day'] );
		$this->assertEquals( 'Poush', $out['nmonth'] );
		$this->assertEquals( '4', $out['num_day'] );
	}

	/**
	 * Test converter nepali to english.
	 *
	 * @since 1.0.0
	 */
	public function test_converter_nepali_to_english() {
		$cal_object = new Nepali_Calendar();

		$year  = 2077;
		$month = 1;
		$day   = 1;

		$out = $cal_object->nep_to_eng( $year, $month, $day );

		$this->assertEquals( '2020', $out['year'] );
		$this->assertEquals( '4', $out['month'] );
		$this->assertEquals( '13', $out['date'] );
		$this->assertEquals( 'Monday', $out['day'] );
		$this->assertEquals( 'April', $out['emonth'] );
		$this->assertEquals( '2', $out['num_day'] );
	}
}
