<?php
/*----------------------------------------
*
* 	Address Widget 	
*
-----------------------------------------*/

/*
 Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'zp_contact_widgets' );

/*
 * Register widget.
 */
function zp_contact_widgets() {
	register_widget( 'ZP_CONTACT_Widget' );
}

/*
 * Widget class.
 */
class zp_contact_widget extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */
	
	function __construct() {
	
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'zp_contact_widget', 'description' => __('A widget that addresss your contact information.', 'novo') );

		/* Create the widget. */
		$this->WP_Widget( 'zp_contact_widget', __('ZP Contact Widget', 'novo'), $widget_ops );
	}

	/* ---------------------------- */
	/* ------- Display Widget -------- */
	/* ---------------------------- */
	
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$telephone = $instance['telephone'];
		$fax = $instance['fax'];
		$email = $instance['email'];
		$address = $instance['address'];
		$skype = $instance['skype'];
		$hours = $instance['hours'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		/* Display Flickr Photos */
		 ?>
			<?php if( $telephone ) {?><p class="highlight"><i class="fa fa-phone contact-footer-icon"></i><span><?php echo $telephone; ?> </span></p><?php } ?>
            <?php if( $fax ) {?><p class="highlight"><span> <?php echo $fax; ?></span></p><?php } ?>
           	<?php if( $email ) {?><p class="highlight"><i class="fa fa-envelope-o contact-footer-icon"></i><span><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></span></p><?php } ?>
            <?php if( $address ) {?><p class="highlight"><i class="fa fa-home contact-footer-icon"></i><span><?php echo $address; ?></span></p>  <?php } ?>   
             <?php if( $skype ) {?><p class="highlight"><span><?php echo $skype; ?></span></p>  <?php } ?> 
             <?php if( $hours ) {?><span class="highlight"><i class="fa fa-clock-o contact-footer-icon"></i><?php echo $hours; ?></span>  <?php } ?> 
           
		<?php

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/* ---------------------------- */
	/* ------- Update Widget -------- */
	/* ---------------------------- */
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['telephone'] = strip_tags( $new_instance['telephone'] );
		$instance['fax'] = $new_instance['fax'];
		$instance['email'] = $new_instance['email'];
		$instance['address'] = $new_instance['address'];
		$instance['skype'] = $new_instance['skype'];
		if($new_instance['paragraphs']=="paragraph"){
			$instance['hours'] = '<span>'.nl2br ($new_instance['hours']).'</span>';
		}else{
			$instance['hours'] = $new_instance['hours'];
		}

		/* No need to strip tags for.. */

		return $instance;
	}

	/**
	 * convert line breaks to paragraphs	
	 * 
	 * 
	 */
	function nl2p($string){
	    $paragraphs = '';

	    foreach (explode("\n", $string) as $line) {
	        if (trim($line)) {
	            $paragraphs .= '<p>' . $line . '</p>';
	        }
	    }
	    $paragraphs =trim(preg_replace('/\s+/', ' ', $paragraphs));
	    return $paragraphs;
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
		'title' => 'Contact',
		'telephone' => '000-000-0000',
		'fax' => '',
		'email' => 'your@email.com',
		'address' => '',
		'skype' => '',
		'hours' => 'Monday - Friday: 10am - 7pm'."\r\n".'Saturday: 10am - 5pm'."\r\n".'Sunday: Closed',	
		'paragraphs'=>'paragraph'
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'novo') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'telephone' ); ?>"><?php _e('Telephone:', 'novo') ?> </label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'telephone' ); ?>" name="<?php echo $this->get_field_name( 'telephone' ); ?>" value="<?php echo $instance['telephone']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'fax' ); ?>"><?php _e('Fax:', 'novo') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'fax' ); ?>" name="<?php echo $this->get_field_name( 'fax' ); ?>" value="<?php echo $instance['fax']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'email' ); ?>"><?php _e('Email:', 'novo') ?> </label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" value="<?php echo $instance['email']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'address' ); ?>"><?php _e('Address:', 'novo') ?> </label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'address' ); ?>" name="<?php echo $this->get_field_name( 'address' ); ?>" value="<?php echo $instance['address']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'skype' ); ?>"><?php _e('Skype:', 'novo') ?> </label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'skype' ); ?>" name="<?php echo $this->get_field_name( 'skype' ); ?>" value="<?php echo $instance['skype']; ?>" />
		</p> 
		<p>
			<label for="<?php echo $this->get_field_id( 'hours' ); ?>"><?php _e('hours:', 'novo') ?> </label>
			<textarea rows="4" cols="50" class="widefat" id="<?php echo $this->get_field_id( 'hours' ); ?>" name="<?php echo $this->get_field_name( 'hours' ); ?>"><?php echo $instance['hours']; ?></textarea>
			<input type="checkbox" id="<?php echo $this->get_field_id( 'paragraphs' ); ?>" name="<?php echo $this->get_field_name( 'paragraphs' ); ?>" value="paragraph" class="widefat"><label for="<?php echo $this->get_field_id( 'paragraphs' ); ?>"><?php _e('Convert line breaks to paragraphs:', 'novo') ?> </label>
		</p>
	<?php
	}
}
?>