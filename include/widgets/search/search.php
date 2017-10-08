<?php
/*----------------------------------------
*
* 	LMSEO Search Widget 	
*
-----------------------------------------*/

/*
 Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'lmseo_search_widgets' );

/*
 * Register widget.
 */
function lmseo_search_widgets() {
	register_widget( 'lmseo_search_widget' );
}

/*
 * Widget class.
 */
/*
*manage post object
*/
require_once(get_stylesheet_directory().'/include/widgets/search/classes/class.custompost.php');
/*
*manage image object
*/
require_once(get_stylesheet_directory().'/include/widgets/search/classes/class.custompostimage.php');

//add_action('template_redirect', 'enable_ajax_func');
//function enable_ajax_func(){
//	wp_localize_script('ajaxify','ajaxify_function',array('ajaxurl' => admin_url('admin-ajax.php' )));
//}

add_action('wp_ajax_nopriv_lmseo_ajax_retrieve_posts_wp_query_with_class','lmseo_ajax_retrieve_posts_wp_query_with_class');
add_action('wp_ajax_lmseo_ajax_retrieve_posts_wp_query_with_class','lmseo_ajax_retrieve_posts_wp_query_with_class' );
function lmseo_ajax_retrieve_posts_wp_query_with_class(){
	header('Content-Type: application/json');

	$search_term = filter_var($_GET['term'],FILTER_SANITIZE_STRING); 
	
	if(empty($search_term)){
		echo false;
	}else{
		$homePage =  get_page_by_title('V & Q Construction');
		$args = array(
			'post_type' => array( 'post','page','slide','portfolio'),
			'post_status'=>'publish',
			's'=>$search_term,
			'post__not_in' => array($homePage->ID),
			'orderby' => 'slide',
			'order'   => 'DESC',
		);

		$posts_array = new WP_Query( $args );
		$arrayOfPostObjects = array();
		$loop_counter = 0;

		if ( $posts_array->have_posts() ) {
			while ( $posts_array->have_posts() ) {
				$posts_array->the_post();
				$postID = get_the_ID();
				$imageSize ="Feature";

				$imageAtt=wp_get_attachment_image_src( get_post_thumbnail_id($postID),$imageSize );

				$myImagePost = new CustomPostImage();

				$myImagePost->setImageSource($imageAtt[0]);
				$myImagePost->setImageHeight($imageAtt[2]);
				$myImagePost->setImageWidth($imageAtt[1]);
				$myImagePost->setPostImageAlt(get_post_meta( $postID, '_wp_attachment_image_alt', true ));

				$myPostArrayObject = new CustomPost($myImagePost);

				$myPostArrayObject->setPostID($postID);
				$myPostArrayObject->setPostTitle(ucwords(get_the_title()));
				$myPostArrayObject->setPostUrl(get_permalink( $myPostArrayObject->getPostId()));
				$myPostArrayObject->setPostExcerpt(get_excerpt_by_id($postID,20));
				$myPostArrayObject->setPostDate(get_the_date());
				$myPostArrayObject->setPostLink($myPostArrayObject->getPostUrl(), $myPostArrayObject->getPostTitle(), 'search-app-title-link');
				$myPostArrayObject->setPostThumbnail(get_the_post_thumbnail( $myPostArrayObject->getPostId(), "Feature", array('class'=>'search-app-img') ));
				$newPostThumbnail = $myPostArrayObject->getPostThumbnail();

				//if no image is available then use a default image
				$myPostArrayObject->setPostThumbnailWithLink($newPostThumbnail,$myPostArrayObject->getPostUrl(),'search-app-img-link' );

				//echo "<ul><li>";
				/*$processed_post_array[$loop_counter]= ["WP_Post Object"=>array(
					"id"=>$postid,
					"title"=>get_the_title(),
					"url"=>get_permalink( $postid),
					"excerpt"=>get_the_excerpt(),
					"date"=>get_the_date(),
					"thumbnail"=>get_the_post_thumbnail( $postid, "Feature" ))];*/
			//	echo  get_the_title() ;
			//	echo "</li>\n\n<li>";
			//	echo get_permalink( $postid, $leavename );
			//	echo "</li>\n\n<li>";
			//	echo the_permalink();
			//	echo "</li></ul>\n\n";
				$arrayOfPostObjects[$loop_counter] = $myPostArrayObject;
				$loop_counter++;
			}
			echo json_encode($arrayOfPostObjects);
			die();

		} else {
		// no posts found
			echo false;
		}
		//$myPostArrayObject = new CreatePostArray();
		//$myPostArrayObject->setPostID('1111111111');
		//$myPostArrayObject->setPostTitle($search_term);
		//$arrayOfPostObjects[$loop_counter] = $myPostArrayObject;
		//print_r($processed_post_array);
		
	}
}

class lmseo_search_widget extends WP_Widget {

	/* ---------------------------- */
	/* -------- Widget setup -------- */
	/* ---------------------------- */
	
	function __construct() {
	
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'lmseo_search_widget', 'description' => __('A widget that adds an search field using angularJS.', 'argos') );

		/* Create the widget. */
		$this->WP_Widget( 'lmseo_search_widget', __('LMSEO Search Widget', 'novo'), $widget_ops );
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
		 ?>
<div data-ng-app="searchApp" class="search-app">
	<div data-ng-controller="pageListController">
		<div data-ng-class="{'search-app-wrapper':isActive, 'search-app-wrapper-active':!isActive}" class="search-app-wrapper">
			<input data-ng-model="search_term" data-ng-keyup="doSearch()" itemprop="query-input" type="search"  placeholder="Search this website">
			<ul class="search-app-list" ng-cloak><li data-ng-repeat="post in posts | orderBy:'postTitle'" class="search-app-list-element list-element-divider clearfix"><span data-ng-bind-html="post.postThumbnailWithLink"></span><h3 class="search-app-title" data-ng-bind-html="post.postLink"></h3><p class="search-app-url">{{post.postUrl}}</p><p class="search-app-excerpt"><span class="search-app-date">{{post.postDate}}</span>&nbsp;-&nbsp;{{post.postExcerpt}}</p></li></ul>
		</div>
	</div>
</div>
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
		'title' => 'Search'
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'novo') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
	<?php
	}
}

?>
