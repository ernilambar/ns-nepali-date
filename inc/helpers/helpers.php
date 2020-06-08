<?php
/**
 * Helpers
 *
 * @package NS_Nepali_Date
 */

// use ErNilambar\NepaliDate\NepaliDate;

// $nd = new NepaliDate();
// try {
// 	$dd_english = $nd->ad_to_bs(2020,1,1);
// 	nspre( $dd_english );

// 	$dd_nepali = $nd->bs_to_ad(2077,1,1);
// 	nspre( $dd_nepali );
// }
// catch(Exception $e) {
//   echo 'Message: ' .$e->getMessage();
// }

/**
 * Get formatted date.
 *
 * @since 1.0.0
 *
 * @param array  $date Date details.
 * @param string $format Format.
 * @return string Formatted date.
 */
function ns_nepali_date_get_formatted_date( $date, $format ) {
	$output = '';

	$find = array_keys( $date );

	$replace = array_values( $date );

	$output = str_replace( $find, $replace, $format );

	return $output;
}

/**
 * Get date details.
 *
 * @since 1.0.0
 *
 * @param array  $date Date.
 * @param string $language Language.
 * @return array Date details.
 */
function ns_nepali_date_get_date_details( $date, $language ) {
	$output = array();

	// Year two digit.
	$year2 = substr( $date['year'], -2 );

	if ( 'np' === $language ) {
		$output['Y'] = ns_nepali_date_get_nepali_number( $date['year'] );
		$output['y'] = ns_nepali_date_get_nepali_number( $year2 );
		$output['j'] = ns_nepali_date_get_nepali_number( $date['day'] );
		$output['d'] = ns_nepali_date_get_nepali_number( $date['day'], true );
		$output['F'] = ns_nepali_date_get_month_text( $date['month'], $language );
		$output['n'] = ns_nepali_date_get_nepali_number( $date['month'] );
		$output['m'] = ns_nepali_date_get_nepali_number( $date['month'], true );
		$output['l'] = ns_nepali_date_get_nepali_day_text( $date['weekday'] );
		$output['D'] = ns_nepali_date_get_nepali_day_text( $date['weekday'], 'D' );
	} else {
		$output['Y'] = (string)$date['year'];
		$output['y'] = $year2;
		$output['j'] = (string)$date['day'];
		$output['d'] = str_pad( $date['day'], 2, '0', STR_PAD_LEFT );
		$output['F'] = ns_nepali_date_get_month_text( $date['month'], $language );
		$output['n'] = (string)$date['month'];
		$output['m'] = str_pad( $date['month'], 2, '0', STR_PAD_LEFT );
		$output['l'] = ns_nepali_date_get_english_day_text( $date['weekday'] );
		$output['D'] = ns_nepali_date_get_english_day_text( $date['weekday'], 'D' );
	}

	return $output;
}

/**
 * Get month text.
 *
 * @since 1.0.0
 *
 * @param int    $month Month in number.
 * @param string $language Language.
 * @return string Month text.
 */
function ns_nepali_date_get_month_text( $month, $language = 'en' ) {
	$output = '';

	$details = ns_nepali_date_get_nepali_month_details();

	if ( isset( $details[ $month ][ $language ] ) ) {
		$output = $details[ $month ][ $language ];
	}

	return $output;
}

/**
 * Get Nepali day text.
 *
 * @since 1.0.0
 *
 * @param int    $day Day in number.
 * @param string $format Format.
 * @return string Week text.
 */
function ns_nepali_date_get_nepali_day_text( $day, $format = 'l' ) {
	$output = '';

	$details = ns_nepali_date_get_nepali_week_details();

	if ( isset( $details[ $day ][ $format ] ) ) {
		$output = $details[ $day ][ $format ];
	}

	return $output;
}

/**
 * Get English day text.
 *
 * @since 1.0.0
 *
 * @param int    $day Day in number.
 * @param string $format Format.
 * @return string Week text.
 */
function ns_nepali_date_get_english_day_text( $day, $format = 'l' ) {
	$output = '';

	$details = ns_nepali_date_get_english_week_details();

	if ( isset( $details[ $day ][ $format ] ) ) {
		$output = $details[ $day ][ $format ];
	}

	return $output;
}

/**
 * Get nepali number.
 *
 * @since 1.0.0
 *
 * @param int  $num Number.
 * @param bool $padding Whether to do padding or not.
 * @param int  $length Padding length.
 * @return string Translated number.
 */
function ns_nepali_date_get_nepali_number( $num, $padding = false, $length = 2 ) {
	$str = array();

	$digits = array( '०', '१', '२', '३', '४', '५', '६', '७', '८', '९' );

	$numarr = str_split( $num );

	$cnt = count( $numarr );

	for ( $i = 0; $i < $cnt; $i++ ) {
		$str[ $i ] = $digits[ $numarr[ $i ] ];
	}

	if ( true === $padding ) {
		$remaining = $length - $cnt;

		if ( $remaining > 0 ) {
			for ( $j = 0; $j < $remaining; $j++ ) {
				array_unshift( $str, $digits[0] );
			}
		}
	}

	return implode( '', $str );
}

/**
 * Get month details.
 *
 * @since 1.0.0
 *
 * @return array Month details.
 */
function ns_nepali_date_get_nepali_month_details() {
	$output = array(
		'1'  => array(
			'en' => 'Baishakh',
			'np' => 'बैसाख',
		),
		'2'  => array(
			'en' => 'Jeth',
			'np' => 'जेठ',
		),
		'3'  => array(
			'en' => 'Ashar',
			'np' => 'असार',
		),
		'4'  => array(
			'en' => 'Shrawan',
			'np' => 'श्रावन',
		),
		'5'  => array(
			'en' => 'Bhadra',
			'np' => 'भाद्र',
		),
		'6'  => array(
			'en' => 'Ashoj',
			'np' => 'असोज',
		),
		'7'  => array(
			'en' => 'Kartik',
			'np' => 'कार्तिक',
		),
		'8'  => array(
			'en' => 'Mangshir',
			'np' => 'मंसिर',
		),
		'9'  => array(
			'en' => 'Poush',
			'np' => 'पुष',
		),
		'10' => array(
			'en' => 'Magh',
			'np' => 'माघ',
		),
		'11' => array(
			'en' => 'Falgun',
			'np' => 'फाल्गुण',
		),
		'12' => array(
			'en' => 'Chaitra',
			'np' => 'चैत्र',
		),
	);

	return $output;
}

/**
 * Get Nepali week details.
 *
 * @since 1.0.0
 *
 * @return array Week details.
 */
function ns_nepali_date_get_nepali_week_details() {
	$output = array(
		'1' => array(
			'l' => 'आइतबार',
			'D' => 'आइत',
		),
		'2' => array(
			'l' => 'सोमबार',
			'D' => 'सोम',
		),
		'3' => array(
			'l' => 'मंगलबार',
			'D' => 'मंगल',
		),
		'4' => array(
			'l' => 'बुधबार',
			'D' => 'बुध',
		),
		'5' => array(
			'l' => 'बिहिबार',
			'D' => 'बिहि',
		),
		'6' => array(
			'l' => 'शुक्रबार',
			'D' => 'शुक्र',
		),
		'7' => array(
			'l' => 'शनिबार',
			'D' => 'शनि',
		),
	);

	return $output;
}

/**
 * Get English week details.
 *
 * @since 1.0.0
 *
 * @return array Week details.
 */
function ns_nepali_date_get_english_week_details() {
	$output = array(
		'1' => array(
			'l' => 'Aaitabar',
			'D' => 'Aaita',
		),
		'2' => array(
			'l' => 'Sombar',
			'D' => 'Som',
		),
		'3' => array(
			'l' => 'Mangalbar',
			'D' => 'Mangal',
		),
		'4' => array(
			'l' => 'Budhabar',
			'D' => 'Budha',
		),
		'5' => array(
			'l' => 'Bihibar',
			'D' => 'Bihi',
		),
		'6' => array(
			'l' => 'Sukhrabar',
			'D' => 'Sukhra',
		),
		'7' => array(
			'l' => 'Sanibar',
			'D' => 'Sani',
		),
	);

	return $output;
}

/**
 * Get example formats.
 *
 * @since 1.0.0
 *
 * @return array Example formats.
 */
function ns_nepali_date_get_example_formats() {
	$output = array(
		array(
			'format' => 'd F Y',
			'label'  => '१८ जेठ २०७७',
		),
		array(
			'format' => 'F d, Y',
			'label'  => 'जेठ १८, २०७७',
		),
		array(
			'format' => 'Y F d',
			'label'  => '२०७७ जेठ १८',
		),
		array(
			'format' => 'l, d F Y',
			'label'  => 'आइतबार, १८ जेठ २०७७',
		),
		array(
			'format' => 'd.m.y',
			'label'  => '१८.०२.७७',
		),
		array(
			'format' => 'Y.m.d',
			'label'  => '२०७७.०२.१८',
		),
		array(
			'format' => 'D, d F',
			'label'  => 'आइत, १८ जेठ',
		),
		array(
			'format' => 'Y F d, l',
			'label'  => '२०७७ जेठ १८, आइतबार',
		),
	);

	return $output;
}
