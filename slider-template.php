<?php 
/*--------------------------------------
 
Template Name: Slider

---------------------------------------*/ 

//during dev set to false. during Dist = true
$sliderDev = true;
//Set to true if critical local not recommended for dist
$criticalLocal = true;

//Include critical path CSS
add_action('wp_head','lmseo_slider_template_critical_css',1);
function lmseo_slider_template_critical_css(){
	$path= 'bin/css/internal/slider/template/critical/styles.min.css.php';
	global $sliderDev;
	if($sliderDev){
		echo '<style type="text/css">';
		include $path;
		echo '</style>';
	}
}
/*
*Removes default CSS
*/
add_action(  'wp_enqueue_scripts', 'lmseo_slider_template_styles'   );
function lmseo_slider_template_styles(   ) {
	global $sliderDev;
	if($sliderDev){
		wp_dequeue_style('argos');
		wp_deregister_style('argos');
	}
	//wp_dequeue_script('internal');
	wp_dequeue_script('internal');
	wp_deregister_script('internal');

	wp_register_script( 'slider_js', get_stylesheet_directory_uri(  ) . '/bin/js/internal/slider/template/main.min.js',false, '1',true );
	wp_enqueue_script('slider_js');
}

add_action('wp_footer','lmseo_slider_template_load_css_asynchronously');
function lmseo_slider_template_load_css_asynchronously(){
	global $sliderDev, $criticalLocal;

	if($sliderDev){
		if($criticalLocal){ ?>
		<script>
		<?php include 'bower_components/loadcss/loadCSS.min.js';?>
		loadCSS('<?php echo "/wp-content/themes/argo/bin/css/internal/slider/template/uncss/complete/style.css";?>');
		</script>
		<noscript><link href="/wp-content/themes/argo/bin/css/internal/slider/template/uncss/complete/style.css" rel="stylesheet"></noscript>
  		<?php
		}else{
			?>
			<script>
			<?php include 'bower_components/loadcss/loadCSS.min.js';?>
			loadCSS('<?php echo "https://489323192bc07f331d47-c06041d322f1ad6b39306f4da82d1689.ssl.cf1.rackcdn.com/wp-content/themes/argo/bin/css/internal/slider/template/uncss/complete/style.css";?>');
			</script>
			<noscript><link href="https://489323192bc07f331d47-c06041d322f1ad6b39306f4da82d1689.ssl.cf1.rackcdn.com/wp-content/themes/argo/bin/css/internal/slider/template/uncss/complete/style.css" rel="stylesheet"></noscript>
			<?php
		}
	}
}
add_action(  'wp_head', 'lmseo_slider_custom_css',1  );
function lmseo_slider_custom_css(){
	wp_dequeue_style('custom');
	wp_deregister_style('custom');
}


/** Force the full width layout layout on the slider page */
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );


//remove_action(	'genesis_loop', 'genesis_do_loop' );
add_action(	'genesis_before_entry', 'lmseo_slider_slider_template' );
function lmseo_slider_slider_template() { 

	global $post;		
	
	//wp_enqueue_script(  'jquery_flexslider_js'  );

	echo '<div class="media_container">';
	           lmseo_page_gallery($post->ID, 'Blog'); 			
	echo '</div>';

	//$items = genesis_get_option( 'zp_num_portfolio_items' , ZP_SETTINGS_FIELD );
	
	//zp_portfolio_template( $items, 'gallery');
   
}
/*lmseo_before_more_information is located inside the theme functions file 
--------------------------------------------------------------------------*/
add_action( 'genesis_before_footer', 'lmseo_before_more_information',2 );

genesis();