<?php 
/*--------------------------------------
 
Template Name: Image

---------------------------------------*/ 

/** Force the full width layout layout on the Portfolio page */
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
remove_theme_support(  'genesis-structural-wraps', array(  'inner')  );
add_theme_support(  'genesis-structural-wraps', array(  'header')  );


//remove_action(	'genesis_loop', 'genesis_do_loop' );
add_action ( 'genesis_entry_header', 'zp_featured_image_title_singular', 2 );
function zp_featured_image_title_singular() {
		$img = genesis_get_image(  'format=url&size=Home' );
		echo '<div class="media_container" style="background-image:url('.$img.')">';
		echo '</div>';
}

genesis();