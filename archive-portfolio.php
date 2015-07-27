<?php
/*------------------------------
 Portfolio Archive Template
------------------------------*/

/** Force the full width layout layout on the Portfolio page */
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
/*remove wrappers for header and inner*/
remove_theme_support('genesis-structural-wraps',array('inner'));
add_theme_support('genesis-structural-wraps',array('header'));

remove_action(	'genesis_loop', 'genesis_do_loop' );
add_action(	'genesis_loop', 'zp_portfolio_archive_template' );
function zp_portfolio_archive_template() {
	$items = genesis_get_option( 'zp_num_archive_items' , ZP_SETTINGS_FIELD );
	//echo 'archive portfolio';
	lmseo_portfolio_template( $items, 'portfolio' );
}
genesis();