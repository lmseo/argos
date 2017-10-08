<?php 
/*------------------------------
Template Name: Angular
------------------------------*/ 
require_once(get_stylesheet_directory().'/include/widgets/search/classes/class.custompost.php');
require_once(get_stylesheet_directory().'/include/widgets/search/classes/class.custompostimage.php');

add_action(  'wp_enqueue_scripts', 'lmseo_angular_js'  );
function lmseo_angular_js(   ) {	

	wp_register_script(  'angular', '//ajax.googleapis.com/ajax/libs/angularjs/1.4.5/angular.min.js' , false, '1.4.5', true); 
	wp_register_script( 'angular-sanitize', '//ajax.googleapis.com/ajax/libs/angularjs/1.4.5/angular-sanitize.js',false, '1',true );
	wp_register_script(  'ui-router', '//angular-ui.github.io/ui-router/release/angular-ui-router.js' , false, '1.4.5', true); 
	
	wp_register_script( 'search-app', get_stylesheet_directory_uri(  ) . '/include/widgets/search/js/app.js',false, '1',true );
	wp_register_script( 'search-app-controllers', get_stylesheet_directory_uri(  ) . '/include/widgets/search/js/controllers.js',false, '1',true );
	wp_register_script( 'search-app-services', get_stylesheet_directory_uri(  ) . '/include/widgets/search/js/services.js',false, '1',true );

	
	//wp_enqueue_script( 'angular');
	//wp_enqueue_script( 'angular-sanitize');
	//wp_enqueue_script( 'search-app');
	//wp_enqueue_script( 'search-app-controllers');
//	wp_enqueue_script( 'search-app-services');
	//wp_dequeue_script(  'internal'  );
}
//add_action(  'genesis_loop', 'lmseo_test_ajax_retrieve_posts_wp_query'  );
function lmseo_test_ajax_retrieve_posts_wp_query(){
	//	header('Content-Type: application/json');
	$args = array(
		'post_type' => array('page', 'post'),
		'post_status'=>'publish',
		's'=>'le'
	);
	$posts_array = new WP_Query( $args );
	//print_r($posts_array);
	$processed_post_array = array( );
	//echo "<ul>";
	$loop_counter=0;
	if ( $posts_array->have_posts() ) {
		while ( $posts_array->have_posts() ) {
			$posts_array->the_post();
			$postid = get_the_ID();
			//echo "<ul><li>";
			$processed_post_array[$loop_counter]= ["WP_Post Object"=>array(
				"id"=>$postid,
				"title"=>get_the_title(),
				"url"=>get_permalink( $postid),
				"excerpt"=>get_the_excerpt(),
				"date"=>get_the_date(),
				"thumbnail"=>get_the_post_thumbnail( $postid, "Feature" ))];
		//	echo  get_the_title() ;
		//	echo "</li>\n\n<li>";
		//	echo get_permalink( $postid, $leavename );
		//	echo "</li>\n\n<li>";
		//	echo the_permalink();
		//	echo "</li></ul>\n\n";
			$loop_counter++;
		}
	} else {
	// no posts found
		_e( 'Sorry, no posts matched your criteria.' );
	}
	print_r($processed_post_array);
	//print_r($posts_array->get_posts());
	//echo json_encode($processed_post_array);
	//echo json_encode($posts_array->get_posts());
	wp_reset_postdata();
}
//add_action(  'genesis_loop', 'lmseo_test_wp_query_ajax_retrieve_posts_wp_query'  );
function lmseo_test_wp_query_ajax_retrieve_posts_wp_query(){
	//header('Content-Type: application/json');
	$args = array(
		'sort_order' => 'asc',
		'sort_column' => 'post_title',
		'hierarchical' => 1,
		'exclude' => '',
		'include' => '',
		'meta_key' => '',
		'meta_value' => '',
		'authors' => '',
		'child_of' => 0,
		'parent' => -1,
		'exclude_tree' => '',
		'number' => '',
		'offset' => 0,
		'post_type' => 'page',
		'post_status' => 'publish'
	); 
	$posts_array = get_pages();
	//print_r($posts_array);
	echo json_encode($posts_array);
	//die();
}
//add_action(  'genesis_loop', 'lmseo_test_ajax_with_class_retrieve_posts_wp_query'  );
function lmseo_test_ajax_with_class_retrieve_posts_wp_query(){
	//	header('Content-Type: application/json');

	$search_term = filter_var($_GET['term'],FILTER_SANITIZE_ENCODED); 
	//echo $search_term ;
	if(empty($search_term)){
		echo false;
	}else{
		$homePage =  get_page_by_title('V & Q Construction');
		echo $homePage->ID;
		$args = array(
			'post_type' => array( 'post','page','slide','portfolio'),
			'post_status'=>'publish',
			's'=>$search_term,
			'post__not_in' => array($homePage->ID)
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
				//print_r($imageAtt);
				$myImagePost = new CustomPostImage();

				$myImagePost->setImageSource($imageAtt[0]);
				$myImagePost->setImageHeight($imageAtt[2]);
				$myImagePost->setImageWidth($imageAtt[1]);
				$myImagePost->setPostImageAlt(get_post_meta( $postID, '_wp_attachment_image_alt', true ));

				$myPostArrayObject = new custompost($myImagePost);


				$myPostArrayObject->setPostID($postID);
				$myPostArrayObject->setPostTitle(ucwords(get_the_title()));
				$myPostArrayObject->setPostUrl(get_permalink( $myPostArrayObject->getPostId()));
				$myPostArrayObject->setPostExcerpt(get_excerpt_by_id($postID,25));
				$myPostArrayObject->setPostDate(get_the_date());
				$myPostArrayObject->setPostThumbnail(get_the_post_thumbnail( $myPostArrayObject->getPostId(), "Feature" ));

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
		} else {
		// no posts found
			_e( 'Sorry, no posts matched your criteria.' );
		}
		//print_r($posts_array);
	
	//print_r($arrayOfPostObjects);
	//print_r($posts_array->get_posts());
	//echo json_encode($arrayOfPostObjects);
	//echo json_encode($posts_array->get_posts());
	}
	
	wp_reset_postdata();
}
genesis();