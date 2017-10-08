<?php
/*
Thanks to
WP Performance Score Booster
https://github.com/dipakcg/wp-performance-score-booster
Speed-up page load times and improve website scores in services like PageSpeed, YSlow, Pingdom and GTmetrix.
Version: 1.4
Author: Dipak C. Gajjar
Author URI: http://dipakgajjar.com
Text Domain: wp-performance-score-booster
*/
// Remove query strings from static content

add_filter( 'script_loader_src', 'lmseo_remove_query_strings_q', 15, 1 );
add_filter( 'style_loader_src', 'lmseo_remove_query_strings_q', 15, 1 );
add_filter( 'script_loader_src', 'lmseo_remove_query_strings_q', 15, 1 );
add_filter( 'style_loader_src', 'lmseo_remove_query_strings_q', 15, 1 );

function lmseo_remove_query_strings_q( $src ) {
	$str_parts = explode( '?ver', $src );
	return $str_parts[0];
}
function lmseo_remove_query_strings_emp( $src ) {
	$str_parts = explode( '&ver', $src );
	return $str_parts[0];
}
?>