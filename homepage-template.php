<?php 
/*------------------------------
Template Name: Home Page
------------------------------*/ 

//during dev set to false. during Dist = true
$portArchDev = true;
//Set to true if critical local not recommended for dist
$criticalLocal = false;

/*
*Inline crital CSS for first browser paint
*/
add_action('wp_head','lmseo_index_critical_css',1);
function lmseo_index_critical_css(){
	$path= 'bin/css/index/critical/styles.min.css.php';
	global $portArchDev;
	if($portArchDev){
		echo '<style type="text/css">';
		include $path;
		echo '</style>';
	}
}
/*
* Loads optimized CSS at the bottom of the page Asynch
*/
add_action('wp_footer','lmseo_index_load_css_asynchronously');
function lmseo_index_load_css_asynchronously(){
	global $portArchDev, $criticalLocal;

	if($portArchDev){
		if($criticalLocal){
			?>
			<script>
			<?php include 'bower_components/loadcss/loadCSS.min.js';?>
			loadCSS('<?php echo "/wp-content/themes/argos/bin/css/index/uncss/complete/style.css";?>');
			</script>
			<noscript><link href="/wp-content/themes/argos/bin/css/index/uncss/complete/style.css" rel="stylesheet"></noscript>
  		<?php
  		}else{
  			?>
			<script>
			<?php include 'bower_components/loadcss/loadCSS.min.js';?>
			loadCSS('<?php echo "https://489323192bc07f331d47-c06041d322f1ad6b39306f4da82d1689.ssl.cf1.rackcdn.com/wp-content/themes/argo/bin/css/index/uncss/complete/style.css";?>');
			</script>
			<noscript><link href="https://489323192bc07f331d47-c06041d322f1ad6b39306f4da82d1689.ssl.cf1.rackcdn.com/wp-content/themes/argo/bin/css/index/uncss/complete/style.css" rel="stylesheet"></noscript>
	  		<?php
  		}
	}
}
/*
*Removes default CSS
*/
add_action(  'wp_enqueue_scripts', 'lmseo_index_print_styles'   );
function lmseo_index_print_styles() {
	global $portArchDev;
	if($portArchDev){
		wp_dequeue_style('argos');
		wp_deregister_style('argos');
	}
}
/*
* Force the full width layout layout on the Portfolio page 
*/
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

/*
*remove wrappers for header and inner
*/
remove_theme_support('genesis-structural-wraps',array( 'header','inner'));

/*
* add body class when full width slider is disable add_filter( 'body_class', 'zp_body_class' );
*/
add_filter( 'body_class', 'zp_body_class' );
function zp_body_class( $classes ) {
global $post;
	
$enable = get_post_meta( $post->ID, 'zp_fullwidth_slider_value', true);

if( $enable == 'false' ){
	$classes[] = 'zp_boxed_home';
}
	return $classes;
}

remove_action(	'genesis_loop', 'genesis_do_loop' );
add_action(	'genesis_loop', 'zp_homepage_template' );
function zp_homepage_template() {
?>
<div id="home-wrap">
<?php
	if(  have_posts( ) ) {											
 		while (  have_posts(  )  ) {
			the_post(  ); 
			
			do_shortcode( the_content() );
		}
	}
?>
</div>
<?php
}
genesis();