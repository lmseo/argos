<?php 
/*------------------------------
 
 Portfolio Taxonomy Template 
 
 ------------------------------*/ 

/** Force the full width layout layout on the Portfolio page */
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

remove_action(	'genesis_loop', 'genesis_do_loop' );
add_action(	'genesis_loop', 'zp_portfolio_category_template' );
function zp_portfolio_category_template() { 
global $post;
	$items = genesis_get_option( 'zp_num_archive_items' , ZP_SETTINGS_FIELD );
//	echo 'taxonomy portfolio category';	
	zp_portfolio_template( $items, 'portfolio');

}

genesis();