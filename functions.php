<?php
/** Start Engine */
require_once(  get_template_directory().'/lib/init.php'  );

/* Add HTML5 markup structure */
add_theme_support( 'html5' );

/** Localization */
load_child_theme_textdomain(  'novo', apply_filters(  'child_theme_textdomain', get_stylesheet_directory(  ) . '/languages', 'novo'  )  );

/** Child Theme */
define(  'CHILD_THEME_NAME', 'novo'   );
define(  'CHILD_THEME_URL', 'http://demo.zigzagpress.com/novo/'   );

/** Custom Post Types */
require_once(  get_stylesheet_directory(  ) . '/include/cpt/super-cpt.php'   );
require_once(  get_stylesheet_directory(  ) . '/include/cpt/zp_cpt.php'   );

/** Theme Option/Functions */
require_once (  get_stylesheet_directory(  ) . '/include/theme_settings.php'   );
require_once (  get_stylesheet_directory(  ) . '/include/theme_functions.php'   );

/* Include Update Notice File  */
require_once(  get_stylesheet_directory(  )  .'/include/updater/theme_updater.php'   );

/** Theme Widgets */
require_once(  get_stylesheet_directory(  )  .'/include/widgets/widget-flickr.php'   );
require_once(  get_stylesheet_directory(  )  .'/include/widgets/widget-address.php'   );
require_once(  get_stylesheet_directory(  )  .'/include/widgets/widget-social_icons.php'   );
require_once(  get_stylesheet_directory(  )  .'/include/widgets/widget-latest_portfolio.php'   );
require_once(  get_stylesheet_directory(  )  .'/include/widgets/widget-cta-after-content.php'   );

/** Theme Shortcode */
require_once(  get_stylesheet_directory(  ) . '/include/shortcodes/shortcode.php'   );

/** Unregister Layout */
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-content' );
genesis_unregister_layout( 'content-sidebar' );


/** Unregister Sidebar */
unregister_sidebar(  'header-right'  );
unregister_sidebar( 'sidebar-alt' );

/** Custom breadcrumbs arguments*/
add_filter(  'genesis_breadcrumb_args', 'zp_breadcrumb_args'  );
function zp_breadcrumb_args(  $args  ) {
    $args['sep']                     = ' &raquo; ';
    $args['list_sep']                = ', '; // Genesis 1.5 and later
    $args['display']                 = true;
    $args['prefix'] = '<div class="breadcrumbs" id="breadcrumbs"><div class="wrap">';
	$args['suffix'] = '</div></div>';
    $args['labels']['author']        = __( 'Archives for ','novo' );
    $args['labels']['category']      = __( 'Archives for ','novo' ); // Genesis 1.6 and later
    $args['labels']['tag']           = __( 'Archives for ','novo' );
    $args['labels']['date']          = __( 'Archives for ','novo' );
    $args['labels']['search']        = __( 'Search for ','novo' );
    $args['labels']['tax']           = __( 'Archives for ','novo' );
    $args['labels']['post_type']     = __( 'Archives for ','novo' );
    $args['labels']['404']           = __( '404','novo' ); // Genesis 1.5 and later
    return $args;
}

/** Add Structural Wraps */
add_theme_support(  'genesis-structural-wraps', array(  'header','subnav','inner', 'footer-widgets','breadcrumbs' )  );

//* Add support for post formats
add_theme_support( 'post-formats', array( 'audio','gallery','link','quote','video', 'image') );

/** Reposition Primary Nav */
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav' );

/** Remove Seondary Nav */
remove_action( 'genesis_after_header', 'genesis_do_subnav' );

/** Theme Stylesheets */
add_action(  'wp_enqueue_scripts', 'zp_print_styles'   );
function zp_print_styles(   ) {

	wp_register_style(  'pretty_photo_css', get_stylesheet_directory_uri(   ).'/css/prettyPhoto.css', '', '3.1.5' );
	//wp_register_style(  'flexslider-css', get_stylesheet_directory_uri(   ).'/css/flexslider.css' , '', '3.1.5' ); using Bower with an updated version of Flexslider
	wp_register_style(  'flexslider-css', get_stylesheet_directory_uri(   ).'/bower_components/flexslider/flexslider.css' , '', '2.5.0' ); 
	//wp_register_style(  'shortcode-css', get_stylesheet_directory_uri(   ).'/include/shortcodes/shortcode.css'  , '', '1.0' ); imported to the style.scss file	
	wp_register_style(  'galereya-css', get_stylesheet_directory_uri(   ).'/bower_components/galereya/src/css/jquery.galereya.css' , '', '0.9.94' ); 	
	//wp_register_style(  'mobile-css', get_stylesheet_directory_uri(   ).'/css/mobile.css' ,'','1.0'  );	using Foundation to handle mobile
	wp_register_style(  'google-fonts', 'http://fonts.googleapis.com/css?family=Nunito:400,300|Roboto:400,400italic,700,500,300,300italic' , '', '' ); 	

	wp_enqueue_style(  'google-fonts' );
	wp_enqueue_style(  'pretty_photo_css'  );	
	//wp_enqueue_style(  'shortcode-css'   );		
	wp_enqueue_style(  'flexslider-css'   );
	// Add mobile style
	//wp_enqueue_style(  'mobile-css'   );
		
	wp_enqueue_style(  'component', get_stylesheet_directory_uri(   ).'/css/component.css' ,'','1.0'  );	
	
	$color = strtolower(  genesis_get_option(  'zp_color_scheme' ,  ZP_SETTINGS_FIELD  )  );
	if(  $color != 'default'  )
		wp_enqueue_style(  'color-scheme', get_stylesheet_directory_uri(   ).'/css/color/'.$color.'.css' ,'','1.0'  );	
}
add_action(  'wp_head', 'lmseo_custom_css',1  );  
function lmseo_custom_css(   ){
	wp_register_style(  'custom', get_stylesheet_directory_uri(   ).'/css/custom.css' , '', '1.0' );
	wp_enqueue_style(  'custom'   );
}
/** Add favicon**/
add_action('wp_head','lmseo_add_favicon');
function lmseo_add_favicon(){
	?>
<link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon-180x180.png">
<link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="/android-chrome-192x192.png" sizes="192x192">
<link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96">
<link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
<link rel="manifest" href="/manifest.json">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="msapplication-TileImage" content="/mstile-144x144.png">
<meta name="theme-color" content="#ffffff">
	<?php
}
/** Shortcode Styles */
add_action(  'admin_enqueue_scripts', 'zp_codes_admin_init'  );  
function zp_codes_admin_init(   ){
	global $current_screen;
	if(  $current_screen->base == 'post'  ){
	
		//enqueue the script and CSS files for the TinyMCE editor formatting buttons
		wp_enqueue_script(  'jquery'  );
		wp_enqueue_script(  'jquery-ui-dialog'  );
		wp_enqueue_script(  'jquery-ui-core'  );
		wp_enqueue_script(  'jquery-ui-sortable'  );

		//set the style files
		wp_enqueue_style(  'shortcode_editor_style',get_stylesheet_directory_uri(   ).'/include/shortcodes/shortcode_editor_style.css'  );
	}

}

/** Theme Scripts */
add_action(  'wp_enqueue_scripts', 'zp_theme_js'  );
function zp_theme_js(   ) {	
	wp_deregister_script('jquery');
	// Register
	wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js', false, '2.1.4',false);
	// jQuery Migrate
	// Deregister core jQuery Migrate
	wp_deregister_script('jquery-migrate');
	// Register
	wp_register_script('jquery-migrate', 'https://code.jquery.com/jquery-migrate-1.2.1.min.js', array('jquery'), '1.2.1',false); // require jquery, as loaded above
	wp_register_script( 'modernizr', get_stylesheet_directory_uri(  ) . '/js/modernizr.js',false,'2.6.2',false );
	wp_register_script( 'jquery_custom', get_stylesheet_directory_uri(  ).'/js/jquery.custom.js', array( 'jquery','jquery-migrate' ), '1.4',true);	
	wp_register_script( 'jquery_easing_js', get_stylesheet_directory_uri(  ) . '/js/jquery-easing.js',array( 'jquery' ), '1.3',true );
	wp_register_script( 'jquery_flexslider_js', get_stylesheet_directory_uri(  ).'/js/jquery.flexslider.js',array( 'jquery' ), '2.0',true ); 
	wp_register_script( 'jquery_prettyphoto_js', get_stylesheet_directory_uri(  ) . '/js/jquery.prettyPhoto.js',array( 'jquery' ),'3.1.5',true );		
	wp_register_script( 'jQuery_ScrollTo_min_js', get_stylesheet_directory_uri(  ) . '/js/jquery.ScrollTo.min.js',array( 'jquery' ) , '1.4.3.1',true);		
	wp_register_script( 'jquery_tipTip', get_stylesheet_directory_uri(  ).'/js/jquery.tipTip.minified.js',array( 'jquery' ), '1.3',true );	
	wp_register_script( 'jquery_Tools', get_stylesheet_directory_uri(  ) . '/js/jquery.Tools.js',array( 'jquery' ),'1.2.7',true );	
	wp_register_script( 'jquery_cycle', get_stylesheet_directory_uri(  ) . '/js/jquery.cycle.lite.js',array( 'jquery' ) , '1.7',true);
	wp_register_script( 'jquery_carouFredSel', get_stylesheet_directory_uri(  ) . '/js/carousel/jquery.carouFredSel.min.js', array( 'jquery' ), '6.2.1' ,true);
	wp_register_script( 'jquery_mousewheel', get_stylesheet_directory_uri(  ) . '/js/carousel/jquery.mousewheel.min.js',array( 'jquery' ), '3.0.6',true );
	wp_register_script( 'jquery_touchswipe', get_stylesheet_directory_uri(  ) . '/js/carousel/jquery.touchSwipe.min.js',array( 'jquery' ), '1.3.3',true);
	wp_register_script( 'jquery_transit', get_stylesheet_directory_uri(  ) . '/js/carousel/jquery.transit.min.js',array( 'jquery' ), '0.9.9',true);
	wp_register_script( 'jquery_throttle', get_stylesheet_directory_uri(  ) . '/js/carousel/jquery.ba-throttle-debounce.min.js', array( 'jquery' ), '1.1',true );	
	wp_register_script( 'jquery_fitvids', get_stylesheet_directory_uri(  ) . '/js/jquery.fitvids.js',array( 'jquery' ), '1.0',true);
	wp_register_script( 'jquery_jplayer', get_stylesheet_directory_uri(  ) . '/js/jquery.jplayer.min.js', array( 'jquery' ), '2.2.0',true );
	wp_register_script( 'postlike', get_stylesheet_directory_uri(  ) . '/js/postlike.js',array( 'jquery' ),'1.0',true );
	wp_register_script( 'modernizr_custom', get_stylesheet_directory_uri(  ) . '/js/portfolio/modernizr_custom.js' );
	wp_register_script( 'classie', get_stylesheet_directory_uri(  ) . '/js/portfolio/classie.js',array( 'jquery' ), '1.0', true );		
	wp_register_script( 'thumbnailGridEffects', get_stylesheet_directory_uri(  ) . '/js/portfolio/thumbnailGridEffects.js',array( 'jquery' ), '1.0', true );
	wp_register_script( 'waypoints', get_stylesheet_directory_uri(  ) . '/js/waypoints.js',array( 'jquery' ), '2.0.3', true );	

	wp_register_script( 'foundation',get_stylesheet_directory_uri(  ) . '/bower_components/foundation/js/foundation.min.js',array( 'jquery' ), '5.5.2', true );
	wp_register_script( 'foundation_app', get_stylesheet_directory_uri(  ) . '/js/app.js',array( 'foundation' ), '1.0', true );
	wp_register_script( 'galereya', get_stylesheet_directory_uri(  ) . '/bower_components/galereya/src/js/jquery.galereya.js',array( 'jquery' ), '0.9.94',true );

	//enqueue script in the footer
	wp_enqueue_script( 'sidebar_script', get_stylesheet_directory_uri(  ) . '/js/sidebar.js', array('modernizr'), '1.0', true );
		
}

/*unfortunately there is no way with the current version of wordpress to output inline scripts which are necesery for this theme*/
add_action(  'wp_enqueue_scripts', 'lmseo_enque_scripts'  );
function lmseo_enque_scripts(   ) {
	wp_enqueue_script(  'jquery'  );
	wp_enqueue_script(  'jquery-migrate'  );
	wp_enqueue_script(  'jquery_easing_js'  );
	wp_enqueue_script(  'jquery_prettyphoto_js'  );
	wp_enqueue_script(  'jQuery_ScrollTo_min_js'  );
	wp_enqueue_script(  'jquery_tipTip'  );
	wp_enqueue_script(  'jquery_Tools'  );
	wp_enqueue_script(  'postlike'  );
	wp_enqueue_script(  'modernizr'  );	
	wp_enqueue_script(  'waypoints'  );
	wp_enqueue_script(  'jquery_custom'  );	
	wp_enqueue_script(  'foundation'  );
	wp_enqueue_script(  'foundation_app'  );
}


/** Custom CSS */
add_action(  'wp_head', 'zp_custom_styles'  );
function zp_custom_styles(   ) {
	$css_custom = genesis_get_option( 'zp_css_code', ZP_SETTINGS_FIELD );
		if( $css_custom ){
			echo '<style type="text/css">'.$css_custom.'</style>';
	}
}

/** Branding **/
add_action('wp_head','lmseo_branding');
function lmseo_branding(){
	if ( ( is_home() || is_front_page() ) && is_page() ) {
		echo '
<!--

Design + Development by                                   
LMSEO © 2015                         
All Rights Reserved.               
www.lmseo.com

-->';
	}
}
/** Custom Favicon */
add_filter( 'genesis_favicon_url', 'zp_favicon_url' );
function zp_favicon_url(  ) {
	$favicon_link = genesis_get_option( 'zp_favicon', ZP_SETTINGS_FIELD );
	if (  $favicon_link  ) {
		$favicon = $favicon_link;
			return $favicon;
	}else 
		return false;
}

/** Custom Logo */
add_action( 'wp_head', 'zp_custom_logo' );
function zp_custom_logo() {
	
	//check if Header was set to image or text
	if( genesis_get_option( 'blog_title' ) == 'image'){
?>
<style type="text/css">
		<?php 	if ( genesis_get_option( 'zp_logo', ZP_SETTINGS_FIELD ) ) { ?>
			 .header-image .site-title a {
					background: url("<?php echo genesis_get_option( 'zp_logo', ZP_SETTINGS_FIELD ); ?>") no-repeat scroll <?php echo genesis_get_option( 'zp_logo_background_pos', ZP_SETTINGS_FIELD ); ?> transparent !important;			
			}
			.header-image .title-area, .header-image .site-title, .header-image .site-title a{	
					height: <?php echo genesis_get_option( 'zp_logo_height', ZP_SETTINGS_FIELD ); ?> !important;
					width: <?php echo genesis_get_option( 'zp_logo_width', ZP_SETTINGS_FIELD ); ?> !important;
			}
			
		<?php } ?>

		<?php 	if ( genesis_get_option( 'zp_600_logo', ZP_SETTINGS_FIELD ) ) { ?>
		 @media only screen and (max-width: 768px) {
			.header-image .site-title a {
					background: url("<?php echo genesis_get_option( 'zp_600_logo', ZP_SETTINGS_FIELD ); ?>") no-repeat scroll <?php echo genesis_get_option( 'zp_600_background_pos', ZP_SETTINGS_FIELD ); ?> transparent !important;			
			}

			.header-image .title-area, .header-image .site-title, .header-image .site-title a{		
					height: <?php echo genesis_get_option( 'zp_600_logo_height', ZP_SETTINGS_FIELD ); ?> !important;
					width: <?php echo genesis_get_option( 'zp_600_logo_width', ZP_SETTINGS_FIELD ); ?> !important;
					max-width: 600px;
			}			
		 }
		<?php } ?>

		<?php 	if ( genesis_get_option( 'zp_480_logo', ZP_SETTINGS_FIELD ) ) { ?>
		@media only screen and (max-width: 600px) {
			.header-image .site-title a {
					background: url("<?php echo genesis_get_option( 'zp_480_logo', ZP_SETTINGS_FIELD ); ?>") no-repeat scroll <?php echo genesis_get_option( 'zp_480_background_pos', ZP_SETTINGS_FIELD ); ?> transparent !important;			
			}

			.header-image .title-area, .header-image .site-title, .header-image .site-title a {			
					height: <?php echo genesis_get_option( 'zp_480_logo_height', ZP_SETTINGS_FIELD ); ?> !important;
					width: <?php echo genesis_get_option( 'zp_480_logo_width', ZP_SETTINGS_FIELD ); ?> !important;
					max-width: 480px;
			}			
		}
		<?php } ?>

		<?php 	if ( genesis_get_option( 'zp_320_logo', ZP_SETTINGS_FIELD ) ) { ?>
		@media only screen and (max-width: 480px) {		
			.header-image .site-title a {
					background: url("<?php echo genesis_get_option( 'zp_320_logo', ZP_SETTINGS_FIELD ); ?>") no-repeat scroll <?php echo genesis_get_option( 'zp_320_background_pos', ZP_SETTINGS_FIELD ); ?> transparent !important;			
			}

			.header-image .title-area, .header-image .site-title, .header-image .site-title a {		
					height: <?php echo genesis_get_option( 'zp_320_logo_height', ZP_SETTINGS_FIELD ); ?> !important;
					width: <?php echo genesis_get_option( 'zp_320_logo_width', ZP_SETTINGS_FIELD ); ?> !important;
					max-width: 320px;
			}			
		}
		<?php } ?>

						
        </style>
<?php
}
}

/** Enable Shortcode in the widget */
add_filter( 'widget_text', 'do_shortcode' );

/** Custom "Rread More" link */
add_filter(  'excerpt_more', 'zp_read_more_link'  );
add_filter( 'the_content_more_link', 'zp_read_more_link' );
add_filter(  'get_the_content_more_link', 'zp_read_more_link'  );

function zp_read_more_link(  ) {
    return '&hellip; <a class="more-link" href="' . get_permalink(  ) . '"> '.__( 'Read More','novo' ).'</a>';
}

/** Custom Post Meta */
add_filter(  'genesis_post_meta', 'zp_post_meta_filter'  );
function zp_post_meta_filter( $post_meta ) {
	$post_meta = '[post_categories sep=", " before="<span>'.__( 'Categories','novo' ).': </span>"] [post_tags sep=", " before="<span>'.__( 'Tags','novo' ).': </span>"]';
	return $post_meta;
}

/** Reposition Breadcrumbs*/
remove_action(  'genesis_before_loop', 'genesis_do_breadcrumbs'  );
add_action(  'genesis_after_header', 'genesis_do_breadcrumbs'  );

/** Reposition Post Info */
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
add_action( 'genesis_entry_header', 'genesis_post_info', 9 );

/* Add separator on Post meta */
add_action( 'genesis_entry_header', 'zp_genesis_post_info_sep', 9 );
function zp_genesis_post_info_sep(){
	if(!is_page() && !is_attachment()){
		echo '<hr class="small">';	
	}
}

/* Add separator on  after page title in page*/
add_action( 'genesis_entry_header', 'zp_genesis_page_title_sep', 13 );
function zp_genesis_page_title_sep(){
	if(is_page() && !is_front_page() && !is_attachment()){
		echo '<hr class="small">';	
	}
}
add_action( 'genesis_entry_header', 'zp_genesis_attach_title_sep', 13 );
function zp_genesis_attach_title_sep(){
	if(is_attachment() && !is_front_page() ){
		echo '<hr class="small">';	
	}
}

/* Remove Home Page Titles */
add_action( 'get_header', 'zp_remove_page_titles' );
function zp_remove_page_titles() {
    if ( ( is_home() || is_front_page() ) && is_page() ) {
        remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
    }
}
 
 
 
//add_action( 'get_header', 'child_remove_page_titles' );
function child_remove_page_titles() {
    if ( is_page( 28 ) ) {
        remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
    }
}
 
 
/*Moved to slider template

add_action ( 'genesis_entry_header', 'zp_featured_image_title_singular', 2 );
function zp_featured_image_title_singular() {
 
	if ( is_page() && genesis_image( array( 'size' => 'Blog' ) ) ){ 
		echo '<div class="media_container">';
		genesis_image( array( 'size' => 'Blog' ) );
		echo '</div>';
	}
}*/
//add_action ( 'genesis_entry_header', 'zp_add_page_content_wrap_open', 2 );
function zp_add_page_content_wrap_open(){
	if( is_page() )
		echo '<div class="post_content">';
}

//add_action ( 'genesis_after_entry', 'zp_add_page_content_wrap_close', 2 );
function zp_add_page_content_wrap_close(){
	if( is_page() )
		echo '</div>';
}
/** Background Support */
add_theme_support(  'custom-background'  );


/** Meta for Mobile */
add_action( 'genesis_meta','zp_for_mobile' );
function zp_for_mobile(  ){?>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<?php
}

/** Developer Tools should show that IE is not using the same "Browser Mode"/"Document Mode" between the two instances of the site, because that's the problem here. IE defaults to different modes depending on if you're using a machine name or not (amongst other things).Adding this to your <head> should sort out the problem: */
add_action( 'genesis_meta','fix_ie_virtual' );
function fix_ie_virtual(  ){?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?php
}

add_action( 'genesis_before_footer','lmseo_widget_after_content',10 );
function lmseo_widget_after_content(){
	if(is_active_sidebar( 'after-content-widget' ) && !is_front_page()):?>
		<div class="widgets clearfix">
			<div class="after-content-widget">
				<div class="wrap">
				<?php dynamic_sidebar( 'after-content-widget' );?>
				</div>
			</div>
		</div>
	<?php endif;
}
/** Footer Area */
remove_action( 'genesis_footer', 'genesis_do_footer' );
add_action( 'genesis_footer', 'zp_do_custom_footer' );
function zp_do_custom_footer(  ) {
	$copyright = genesis_get_option( 'zp_footer_text', ZP_SETTINGS_FIELD );?>
<?php if(is_active_sidebar( 'bottom-widget' ) || is_active_sidebar( 'footer-sidebar-1' ) || is_active_sidebar( 'footer-sidebar-2' ) || is_active_sidebar( 'footer-sidebar-3' )):?>
<div class="widgets">
<?php endif;
	if(is_active_sidebar( 'bottom-widget' )):?>
		<div class="footer-widgets-top">
			<div class="row">
		<?php dynamic_sidebar( 'bottom-widget' );?>
			</div>
		</div><?php
	endif;
	if(is_active_sidebar( 'footer-sidebar-1' ) || is_active_sidebar( 'footer-sidebar-2' ) || is_active_sidebar( 'footer-sidebar-3' )):?>
		<div class="footer-widgets-bottom">
			<div class="row">
	    <?php if(is_active_sidebar( 'footer-sidebar-1' )):?>
	    	<div class="medium-4 columns">
			<?php dynamic_sidebar( 'footer-sidebar-1' ); ?>
			</div>
		<?php endif;
		if(is_active_sidebar( 'footer-sidebar-2' )):?>
			<div class="medium-4 columns">
			<?php dynamic_sidebar( 'footer-sidebar-2' );?>
			</div>
		<?php endif;
		if(is_active_sidebar( 'footer-sidebar-3' )):?>
			<div class="medium-4 columns">
			<?php dynamic_sidebar( 'footer-sidebar-3' );?>
			</div>
		<?php endif;?>
			</div>
		</div>
	<?php endif;
	if(is_active_sidebar( 'bottom-widget' ) || is_active_sidebar( 'footer-sidebar-1' ) || is_active_sidebar( 'footer-sidebar-2' ) || is_active_sidebar( 'footer-sidebar-3' )):?>
 </div>
<?php endif;?>
<div class="creds">&copy; 
  			<?php
			if(  $copyright ){
				echo $copyright ;
			}else{
				?>
                
		<?php echo date(  "Y" ). " "; bloginfo( 'name' ); ?>
  ::
  <?php bloginfo(  'description' );
			}?>
<div class="developed">Developed by <a href="http://lmseo.com/">LMSEO</a></div>
</div>

<?php }

/** Widgets */
/* Added 3 more widget sections at the bottom of the footer
genesis_register_sidebar( array( 
	'name'=>'Bottom Widget',
	'id' => 'bottom-widget',
	'description' => __( 'This is the widget area at the bottom of the page right of footer credits.','novo' ),
	'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget'  => '</div>',
	'before_title'=>'<div class="section-title"> <span>','after_title'=>'</span></div>'
 ) );*/
genesis_register_sidebar( array( 
	'name'=>'Bottom Widget',
	'id' => 'bottom-widget',
	'description' => __( 'This is the widget area at the bottom of the page right of footer credits.','novo' ),
	'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">', 
	'after_widget'  => '</aside>',
	'before_title'=>'<h3 class="widget-title">',
	'after_title'=>'</h3>'
 ) );


genesis_register_sidebar( array(
'name' => 'Footer Sidebar 1',
'id' => 'footer-sidebar-1',
'description' => 'Appears in the footer area',
'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
'after_widget' => '</aside>',
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
genesis_register_sidebar( array(
'name' => 'Footer Sidebar 2',
'id' => 'footer-sidebar-2',
'description' => 'Appears in the footer area',
'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
'after_widget' => '</aside>',
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
genesis_register_sidebar( array(
'name' => 'Footer Sidebar 3',
'id' => 'footer-sidebar-3',
'description' => 'Appears in the footer area',
'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">',
'after_widget' => '</aside>',
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
genesis_register_sidebar( array( 
	'name'=>'After Content Widget',
	'id' => 'after-content-widget',
	'description' => __( 'This is the widget below the page content.','novo' ),
	'before_widget' => '<aside id="%1$s" class="widget %2$s clearfix">', 
	'after_widget'  => '</aside>',
	'before_title'=>'<h3 class="widget-title">',
	'after_title'=>'</h3>'
 ) );
/** Footer Widget */
//add_theme_support(  'genesis-footer-widgets', 3  );

/** Add widget title container */
add_filter(  'widget_title', 'zp_widget_title'  );
function zp_widget_title(  $title  ){
	if(  $title  )
		return sprintf( '<span class="widget-line">%s</span>', $title  );
}

/* Run wpauto after the shortcode to avoid adding unnecessary <p> and <br> **/
remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');

add_filter('the_content', 'wpautop', 15);
add_filter('the_content', 'wptexturize', 15);

/* Add top intro text */
//add_action( 'genesis_header' , 'zp_add_header_welcome_text');
function zp_add_header_welcome_text(){
?>
<div class="welcome_message">
    <?php
		if( genesis_get_option( 'zp_welcome_enable',ZP_SETTINGS_FIELD  ) ) {
			echo do_shortcode( genesis_get_option( 'zp_welcome_message' ,  ZP_SETTINGS_FIELD ) );
		}
    ?>
	</div><hr class="small">
<?php 		
}

/* Add Like Post in archives  */

add_filter( 'genesis_post_info', 'zp_post_info_filter' );
function zp_post_info_filter($post_info) {
	
	if( !is_single() ){
		$like = '[post_like]';
	}else{
		$like='';
	}
	
	$post_info = '[post_date] by [post_author_posts_link] [post_comments]'.$like;
	return $post_info;
}


/* Add like */
add_action( 'genesis_entry_footer','zp_add_like_button', 50 );
function zp_add_like_button(){
global $post;

if( !is_page() && is_single() ){
$likes = get_post_meta($post->ID,'zp_like',true);
?>
<div class="post_like">
<p class="likes text-right <?php echo $post->ID; ?>"><span class="icon-heart <?php echo $post->ID; ?>">R</span>
<span class= "textLike"><?php _e('Like this post','novo');?></span>
<span class="likes_value"><em>(<?php echo $likes ? $likes: '0';?>)</em></span>
</p>
</div>
<?php 	
}
}

add_action( 'genesis_meta','zp_add_like_variables');
function zp_add_like_variables(){
	global $post;
?>
        <script>
            var template_directory = "<?php echo get_template_directory_uri(); ?>";
            var ajax_url = "<?php echo admin_url('admin-ajax.php'); ?>";
			var like_msg = "<?php _e('You liked this post', 'novo'); ?>";
        </script>
<?php 		
}

/*
 * Add Sidebar
 *
 */

add_action( 'genesis_before_header', 'zp_custom_sidebar' );

function zp_custom_sidebar(){
	echo '<div id="site-wrapper"><div id="sidebar_container">';
	get_sidebar();
	echo '</div>';
}


add_action( 'genesis_after_footer', 'zp_close_site_wrapper' );
function zp_close_site_wrapper(){
	echo '</div>';	
}

/*
 * To Top Link 
 */
add_action( 'genesis_after_footer','zp_add_top_link' );
function zp_add_top_link(  ){
	echo '<a href="#top" id="top-link"> &uarr; '. __( 'Top of Page','novo' ) .'</a>';
}

/*
 * Add Menu in Sidebar when mobile view
 */
 
add_action( 'genesis_before_sidebar_widget_area', 'zp_mobile_menu' );

/*function zp_mobile_menu(){
	echo '<div id="close_sidebar" class="close-btn" ></div><section class="mobile_menu widget" style="display:none;"><div class="menu_trigger">'.__( 'Menu' , 'novo' ).'<span class="zp_menu_trigger_indicator">4</span></div>';
 		wp_nav_menu( array( 'theme_location' => 'primary', 'container'=> 'div','container_id' => 'nav' , 'menu_class'      => 'menu', 'after' => '<span class="zp_menu_indicator zp-icon close">/</span>' ) ); 
	echo '</section>';
}*/

function zp_mobile_menu(){
	//echo '<div id="close_sidebar" class="close-btn" ></div><section class="mobile_menu widget" style="display:none;">';
	echo '<div id="close_sidebar" class="close-btn" ></div><section class="mobile_menu widget" style="display:none;">';
 		wp_nav_menu( array( 'theme_location' => 'primary', 'container'=> 'div','container_id' => 'nav' , 'menu_class'      => 'menu' ) ); 
	echo '</section>';
}
 
/*
 * Add sticky header
 */
 
add_action( 'genesis_before_header', 'genesis_do_subnav' , 5);

/*
 * Add Custom Sidebar Trigger
 */

add_action( 'genesis_before', 'zp_custom_sidebar_trigger', 8 );

function zp_custom_sidebar_trigger(){
	echo '<div id="custom_sidebar_tigger" class="nav-btn"></div>';
}


/* 
 * Add footer separator 
 */
add_action( 'genesis_footer', 'zp_footer_sep', 5 );
function zp_footer_sep(){
		//echo '<hr>';
		echo '';	
}

/*
 * Add body class if color scheme is used
 */
 
add_filter( 'body_class', 'zp_add_colorscheme_body_class' );
function zp_add_colorscheme_body_class( $classes ) {
	
	$color = strtolower(  genesis_get_option(  'zp_color_scheme' ,  ZP_SETTINGS_FIELD  )  );
	if(  $color != 'default'  ){
	   $classes[] = 'zp_color_scheme '.$color;
	}
	
   return $classes;
}

/*
 * Include IE 9 fixed CSS
 */
add_action( 'wp_head','zp_ie9_fix' );
function zp_ie9_fix(){
	?>
<!--[if gte IE 9]><link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(  )?>/css/ie_fixes.css"><![endif]-->
<?php
}


/*Inset olark code for live chat
 */
add_action( 'wp_footer','lmseo_olark' );
function lmseo_olark(){
	?>
<!-- begin olark code -->
<script data-cfasync="false" type='text/javascript'>/*<![CDATA[*/window.olark||(function(c){var f=window,d=document,l=f.location.protocol=="https:"?"https:":"http:",z=c.name,r="load";var nt=function(){
f[z]=function(){
(a.s=a.s||[]).push(arguments)};var a=f[z]._={
},q=c.methods.length;while(q--){(function(n){f[z][n]=function(){
f[z]("call",n,arguments)}})(c.methods[q])}a.l=c.loader;a.i=nt;a.p={
0:+new Date};a.P=function(u){
a.p[u]=new Date-a.p[0]};function s(){
a.P(r);f[z](r)}f.addEventListener?f.addEventListener(r,s,false):f.attachEvent("on"+r,s);var ld=function(){function p(hd){
hd="head";return["<",hd,"></",hd,"><",i,' onl' + 'oad="var d=',g,";d.getElementsByTagName('head')[0].",j,"(d.",h,"('script')).",k,"='",l,"//",a.l,"'",'"',"></",i,">"].join("")}var i="body",m=d[i];if(!m){
return setTimeout(ld,100)}a.P(1);var j="appendChild",h="createElement",k="src",n=d[h]("div"),v=n[j](d[h](z)),b=d[h]("iframe"),g="document",e="domain",o;n.style.display="none";m.insertBefore(n,m.firstChild).id=z;b.frameBorder="0";b.id=z+"-loader";if(/MSIE[ ]+6/.test(navigator.userAgent)){
b.src="javascript:false"}b.allowTransparency="true";v[j](b);try{
b.contentWindow[g].open()}catch(w){
c[e]=d[e];o="javascript:var d="+g+".open();d.domain='"+d.domain+"';";b[k]=o+"void(0);"}try{
var t=b.contentWindow[g];t.write(p());t.close()}catch(x){
b[k]=o+'d.write("'+p().replace(/"/g,String.fromCharCode(92)+'"')+'");d.close();'}a.P(2)};ld()};nt()})({
loader: "static.olark.com/jsclient/loader0.js",name:"olark",methods:["configure","extend","declare","identify"]});
/* custom configuration goes here (www.olark.com/documentation) */
olark.identify('1634-660-10-8865');/*]]>*/</script><noscript><a href="https://www.olark.com/site/1634-660-10-8865/contact" title="Contact us" target="_blank">Questions? Feedback?</a> powered by <a href="http://www.olark.com?welcome" title="Olark live chat software">Olark live chat software</a></noscript>
<!-- end olark code -->
<?php
}