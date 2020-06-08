<?php
/**
 * Helpers
 *
 * @package NS_Nepali_Date
 */

use ErNilambar\NepaliDate\NepaliDate;

$nd = new NepaliDate();
try {
	$dd_english = $nd->ad_to_bs(2020,1,1);
	nspre( $dd_english, 'first' );

	$detail = $nd->get_date_details( $dd_english );
	nspre( $detail, 'detail' );

	// $dd_nepali = $nd->bs_to_ad(2077,1,1);
	// nspre( $dd_nepali );
}
catch(Exception $e) {
  echo 'Message: ' .$e->getMessage();
}

return;

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
