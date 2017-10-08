<?php
/*----------------------------------------
*
* 	CTA after CW 	
*
-----------------------------------------*/

/*
 Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'lmseo_custom_menu_widgets' );

/*
 * Register widget.
 */
function lmseo_custom_menu_widgets() {
	register_widget( 'lmseo_custom_menu' );
}

/*
 * Widget class.
 */
class lmseo_custom_menu extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */
	
	function __construct() {
	
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'lmseo_custom_menu', 'description' => __('A widget that displays the main menu for mobile screens only.', 'novo') );

		/* Create the widget. */
		$this->WP_Widget( 'lmseo_custom_menu', __('LMSEO Custom Menu', 'novo'), $widget_ops );
	}

	/* ---------------------------- */
	/* ------- Display Widget -------- */
	/* ---------------------------- */
	
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		/*$title = apply_filters('widget_title', $instance['title'] );
		$telephone = $instance['telephone'];*/

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		/*if ( $title )
			echo $before_title . $title . $after_title;*/

		/* Display lmseo mobile menu after content */
		$lcm = $instance['lcm'];
		if ( $lcm=='lcm' ){
			echo '<section class="mobile_menu widget">';
	 		wp_nav_menu( array( 'theme_location' => 'primary', 'container'=> 'div','container_id' => 'nav' , 'menu_class'=> 'menu' ) );
	 		echo '</section>';
	 	}
   
		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/* ---------------------------- */
	/* ------- Update Widget -------- */
	/* ---------------------------- */
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['lcm'] = $new_instance['lcm'];

		/* No need to strip tags for.. */

		return $instance;
	}
	/* ---------------------------- */
	/* ------- Widget Settings ------- */
	/* ---------------------------- */
	
	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(
		'lcm' => ''
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		<p>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'lcm' ); ?>" name="<?php echo $this->get_field_name( 'lcm' ); ?>" value="lcm" class="widefat"<?php if($instance['lcm']=='lcm'):?> checked<?php endif;?>><label for="<?php echo $this->get_field_id( 'lcm' ); ?>"><?php _e('Display mobile menu:', 'novo') ?> </label>
		</p>
	<?php
	}
}
?>