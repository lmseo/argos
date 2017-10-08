<?php
/*------------------------------
 Portfolio Archive Template
------------------------------*/
/*
*Inline crital CSS for first browser paint
*/
//during dev set to false. during Dist = true
$portArchDev = true;
//Set to true if critical local not recommended for dist
$criticalLocal = true;
//echo 'archive';

//Include critical path CSS
add_action('wp_head','lmseo_portfolio_archive_critical_css',1);
function lmseo_portfolio_archive_critical_css(){
	$path= 'bin/css/internal/portfolio/archive/critical/styles.min.css.php';
	global $portArchDev;
	if($portArchDev){
		echo '<style type="text/css">';
		include $path;
		echo '</style>';
	}
}
/*
*Removes default CSS
*/
add_action(  'wp_enqueue_scripts', 'lmseo_portfolio_archive_styles'   );
function lmseo_portfolio_archive_styles(   ) {
	global $portArchDev;
	if($portArchDev){
		wp_dequeue_style('argos');
		wp_deregister_style('argos');
	}
}

add_action('wp_footer','lmseo_portfolio_archive_load_css_asynchronously');
function lmseo_portfolio_archive_load_css_asynchronously(){
	global $portArchDev, $criticalLocal;

	if($portArchDev){
		if($criticalLocal){ ?>
		<script>
		<?php include 'bower_components/loadcss/loadCSS.min.js';?>
		loadCSS('<?php echo "/wp-content/themes/argo/bin/css/internal/portfolio/archive/uncss/complete/style.css";?>');
		</script>
		<noscript><link href="/wp-content/themes/argo/bin/css/internal/portfolio/archive/uncss/complete/style.css" rel="stylesheet"></noscript>
  		<?php
		}else{
			?>
			<script>
			<?php include 'bower_components/loadcss/loadCSS.min.js';?>
			loadCSS('<?php echo "/wp-content/themes/argo/bin/css/internal/portfolio/archive/uncss/complete/style.css";?>');
			</script>
			<noscript><link href="https://489323192bc07f331d47-c06041d322f1ad6b39306f4da82d1689.ssl.cf1.rackcdn.com/wp-content/themes/argo/bin/css/internal/portfolio/archive/uncss/complete/style.css" rel="stylesheet"></noscript>
			<?php
		}
	}
}
//echo 'archive portfolio';
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