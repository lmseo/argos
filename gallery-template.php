<?php 
/*--------------------------------------
 
Template Name: Gallery

---------------------------------------*/ 

/** Force the full width layout layout on the Portfolio page */
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );


remove_action(	'genesis_loop', 'genesis_do_loop' );
add_action(	'genesis_loop', 'zp_portfolio_gallery_template' );
function zp_portfolio_gallery_template() { 

	global $post;		
	
	$items = genesis_get_option( 'zp_num_portfolio_items' , ZP_SETTINGS_FIELD );
	
	zp_portfolio_template( $items, 'gallery');
   
}
/*lmseo_before_more_information is located inside the theme functions file 
--------------------------------------------------------------------------*/
add_action( 'genesis_before_footer', 'lmseo_before_more_information',2 );
genesis();