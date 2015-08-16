<?php
/**Main Sidebar Template
 */

//* Output primary sidebar structure
genesis_markup( array(
	'html5'   => '<aside %s>',
	'xhtml'   => '<div id="sidebar" class="sidebar widget-area">',
	'context' => 'sidebar-primary',
) );

do_action( 'genesis_before_sidebar_widget_area' );
do_action( 'genesis_sidebar' );
do_action( 'genesis_after_sidebar_widget_area' );

genesis_markup( array(
	'html5' => '</aside>', //* end .sidebar-primary
	'xhtml' => '</div>', //* end #sidebar
) );
