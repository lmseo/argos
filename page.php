<?php
/**
 * Page Template.
 */


//echo'novo page';//* This file handles pages, but only exists for the sake of child theme forward compatibility.
add_action( 'genesis_before_footer', 'lmseo_page_before_more_information',2 );
function lmseo_page_before_more_information() { ?>
	<div class="before-more-information"></div>
<?php 
}
genesis();
