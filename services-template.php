<?php 
/*--------------------------------------
 
Template Name: Services

---------------------------------------*/ 

//during dev set to false. during Dist = true
$imageModalDev = true;
//Set to true if critical local not recommended for dist
$criticalLocal = true;

//Include critical path CSS
add_action('wp_head','lmseo_image_modal_template_critical_css',1);
function lmseo_image_modal_template_critical_css(){
	$path= 'bin/css/internal/services/critical/styles.min.css.php';
	global $imageModalDev;
	if($imageModalDev){
		echo '<style type="text/css">';
		include $path;
		echo '</style>';
	}
}
/*
*Removes default CSS
*/
add_action(  'wp_enqueue_scripts', 'lmseo_image_modal_template_styles'   );
function lmseo_image_modal_template_styles(   ) {
	global $imageModalDev;
	if($imageModalDev){
		wp_dequeue_style('argos');
		wp_deregister_style('argos');
		//wp_dequeue_style('custom');
	}else{
		wp_dequeue_style('argos');
		wp_deregister_style('argos');

		wp_register_style( 'services', get_stylesheet_directory_uri(  ) . '/bin/css/internal/services/style.css','', '1.0' );
		wp_enqueue_style('services');
		wp_dequeue_style('custom');
	}
	
	wp_dequeue_script('internal');
	wp_register_script( 'services_js', get_stylesheet_directory_uri(  ) . '/bin/js/internal/services/template/main.min.js',false, '1',true );
	wp_enqueue_script('services_js');
}

//adds Asyn attribute to the script tag
add_filter('script_loader_tag', 'add_defer_attribute', 10, 2);
function add_defer_attribute($tag, $handle) {
    if ( 'services_js' !== $handle )
        return $tag;
    return str_replace( ' src', ' defer="defer" src', $tag );
}


add_action('wp_footer','lmseo_image_modal_template_load_css_asynchronously');
function lmseo_image_modal_template_load_css_asynchronously(){
	global $imageModalDev, $criticalLocal;

	if($imageModalDev){
		if($criticalLocal){ ?>
		<script>
		<?php include 'bower_components/loadcss/loadCSS.min.js';?>
		loadCSS('<?php echo "/wp-content/themes/argo/bin/css/internal/services/uncss/complete/style.css";?>');
		</script>
		<noscript><link href="/wp-content/themes/argo/bin/css/internal/services/uncss/complete/style.css" rel="stylesheet"></noscript>
  		<?php
		}else{
			?>
			<script>
			<?php include 'bower_components/loadcss/loadCSS.min.js';?>
			loadCSS('<?php echo "https://489323192bc07f331d47-c06041d322f1ad6b39306f4da82d1689.ssl.cf1.rackcdn.com/wp-content/themes/argo/bin/css/internal/services/uncss/complete/style.css";?>');
			</script>
			<noscript><link href="https://489323192bc07f331d47-c06041d322f1ad6b39306f4da82d1689.ssl.cf1.rackcdn.com/wp-content/themes/argo/bin/css/internal/services/uncss/complete/style.css" rel="stylesheet"></noscript>
			<?php
		}
	}
}

add_action(  'wp_head', 'lmseo_image_modal_custom_css',1  );
function lmseo_image_modal_custom_css(){
	wp_dequeue_style('custom');
	wp_deregister_style('custom');
}

/** Force the full width layout layout on the Portfolio page */
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
//remove_action(  'genesis_after_header', 'genesis_do_breadcrumbs'  );

remove_theme_support(  'genesis-structural-wraps', array(  'inner')  );
add_theme_support(  'genesis-structural-wraps', array(  'header')  );


//remove_action(	'genesis_loop', 'genesis_do_loop' );
//remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
//remove_action( 'genesis_entry_header', 'genesis_do_post_content' );
//remove_action( 'genesis_entry_header', 'zp_genesis_page_title_sep', 13 );
add_action ( 'genesis_entry_header', 'lmseo_image_modal_featured_image_singular',2 );
function lmseo_image_modal_featured_image_singular() {
		$img = genesis_get_image(  'format=url&size=Home' );
		$bannerTitle = '';

		//cusmtom fields added to the service pages
		$bannerTitle_1 = get_post_meta( get_the_ID(), 'services-banner-title-first', true );
		$bannerTitle_2 = get_post_meta( get_the_ID(), 'services-banner-title-second', true );

		if(!empty($bannerTitle_1)){
			$bannerTitle .= '<h4 class="banner_title banner-title-first">'.$bannerTitle_1.'</h4>';
		}
		if(!empty($bannerTitle_2)){
			$bannerTitle .= '<h4 class="banner_title banner-title-second">'.$bannerTitle_2.'</h4>';
		}
		//print_r($img);
		echo '<div class="banner_container hide-for-small" style="background:url('.$img.') no-repeat center center fixed; background-size:cover;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;"><div class="banner_dirty-top"></div><div class="row banner_tittle_wrapper">'.$bannerTitle.'</div><div class="banner_dirty-bottom"></div>';
		//genesis_do_post_title();
		//genesis_do_post_content();
		echo '</div>';
}

genesis();