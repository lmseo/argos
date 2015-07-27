<?php 
/*------------------------------
 
 Portfolio Single Page 

------------------------------*/ 
add_filter(  'genesis_breadcrumb_args', 'lmseo_single_portfolio_breadcrumb_args'  );
function lmseo_single_portfolio_breadcrumb_args(  $args  ) {
    $args['prefix'] = '<div class="breadcrumbs"><div class="wrap">';
	$args['suffix'] = '</div></div>';
    return $args;
}
/*remove wrappers for header and inner*/
remove_theme_support('genesis-structural-wraps',array( 'header','inner'));

remove_action(  'genesis_after_header', 'genesis_do_breadcrumbs'  );
add_action( 'genesis_after_entry', 'genesis_do_breadcrumbs' );

//remove_action( 'genesis_before_footer','lmseo_widget_after_content' );
//add_action( 'genesis_before_footer', 'lmseo_widget_after_content' );





/** Force the full width layout layout on the Portfolio page */
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

add_action( 'wp_head','single_portfolio_ie9_fix' );
function single_portfolio_ie9_fix(){
	?>
<!--[if lt IE 9]><link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(  )?>/bower_components/galereya/src/css/jquery.galereya.ie.css"><![endif]-->
<?php
}

add_action( 'wp_enqueue_scripts', 'single_portfolio_name_scripts' );
function single_portfolio_name_scripts() {
	wp_enqueue_style(  'galereya-css');
	wp_enqueue_script(  'galereya'  );
	wp_enqueue_script( 'galereya-custom', get_stylesheet_directory_uri(  ) . '/js/custom.galereya.js',array( 'jquery', 'galereya' ), '1.0', true );
}

remove_action( 	'genesis_loop', 'genesis_do_loop'  );
add_action( 'genesis_loop', 'zp_single_portfolio_template'  );

function zp_single_portfolio_template(  ) { 
	global  $post;
	printf( '<article %s>', genesis_attr( 'entry' ) );
	?>
	  <div class="portfolio_single_feature">
	<?php 
	if (have_posts()) {
		while (have_posts()){
		the_post(); 
		$args = array(
		    'orderby' => 'menu_order',
		    'order' => 'ASC',
		    'post_type' => 'attachment',
		    'post_parent' => $post->ID,
		    'post_mime_type' => 'image',
		    'post_status' => null,
		    'numberposts' => -1
		);
		$attachments = get_posts($args);
		//print_r($attachments);
		if( !empty($attachments) ) {
			?>
			<div id="portfolio-gallery-container">
			<?php
			$counter=0;
		    foreach( $attachments as $attachment ) {

		    	$image=lmseo_get_attachment($attachment,'3col');
		    	if(!empty($image)){
		    		if($counter==0){ 
		    			$featuredImage = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'Blog' );
		    			?>
		    			<img src="http://da79db5a66cfbfa8f589-c06041d322f1ad6b39306f4da82d1689.r29.cf1.rackcdn.com/wp-content/themes/novo/images/portfolio/bg.jpg"
				            alt="<?php echo the_title('','', false ); ?>"
				            title="<h1><?php echo the_title('','', false ); ?></h1>"
				            data-desc=""
				            data-category="image"
				            data-fullsrc="<?php echo $featuredImage['0']; ?>"
				            class="portfolio-header" 
				             ><?php

		    		}
			        //$src = wp_get_attachment_image_src( $attachment->ID, $imagesize );
			        //$caption = $attachment->post_excerpt;
			        $caption = ($image['caption']) ? "<div class='slide-caption'>$caption</div>" : '';
			        $alt = ( !empty($image['alt']) ) ? $image['alt'] : $image['description'];
			        $alt =(!empty($alt)) ? ' alt="'.$alt.'"':'';
			        //echo "<li><div>".$caption."<img height='".$image['height']."' width='".$image['width']."' src='".$image['source']."'".$alt." ></div></li>";
			        ?><img src="<?php echo $image['source']; ?>"
				            alt="<?php echo $alt; ?>"
				            title="<?php echo $image['title']; ?>"
				            data-desc="<?php echo $image['description']; ?>"
				            data-category="image"
				            data-fullsrc="<?php echo $image['src']; ?>" 
				             >
				    <?php
			        //All the size information from the attached images
			        //print_r(wp_get_attachment_metadata($attachment->ID));
			        //all info from a single image
			        //print_r(lmseo_get_attachment($attachment,'thumbnail'));
			        //print_r($image);
			        $counter++;
		    	}
			}
		?>
		</div>
		<?php 
		}else{
		//get portfolio meta settings
			$image1 = get_post_meta( $post->ID, 'zp_image_1_value', true );
			$image2 = get_post_meta( $post->ID, 'zp_image_2_value', true );
			$image3 = get_post_meta( $post->ID, 'zp_image_3_value', true );
			$image4 = get_post_meta( $post->ID, 'zp_image_4_value', true );
			$image5 = get_post_meta( $post->ID, 'zp_image_5_value', true );
			
			$thumbnail = wp_get_attachment_url(  get_post_thumbnail_id(  $post->ID  )  );
			
			$video_url = get_post_meta( $post->ID, 'zp_video_url_value', true );
			$video_embed = get_post_meta( $post->ID, 'zp_video_embed_value', true );
			$video_ht = get_post_meta( $post->ID, 'zp_height_value', true );
				    
			if( $video_url !='' || $video_embed!= '' ){ ?>
				<div class="portfolio_single_video">
			<?php
				wp_enqueue_script('jquery_fitvids');

				if( trim( $video_embed ) == '' ){
					if( preg_match( '/youtube/', $video_url ) ){	
						//preg_match_all('#(http://www.youtube.com)?/(v/([-|~_0-9A-Za-z]+)|watch\?v\=([-|~_0-9A-Za-z]+)&?.*?)#i',$string,$output)
						if( preg_match_all('#(http://www.youtube.com)?/(v/([-|~_0-9A-Za-z]+)|watch\?v\=([-|~_0-9A-Za-z]+)&?.*?)#i', $video_url, $matches ) ){
							$output = '<iframe title="YouTube video player" class="youtube-player" type="text/html"  width="1100" height="619"  src="http://www.youtube.com/embed/'.$matches[4][0].'" frameborder="0" allowFullScreen></iframe>';
						}else{
							$output = __( 'Sorry that seems to be an invalid <strong>YouTube</strong> URL. Please check it again.', 'amelie' );
						}	
					}elseif( preg_match( '/vimeo/', $video_url ) ){
						if( preg_match('/^http:\/\/(www\.)?vimeo\.com\/(clip\:)?(\d+).*$/', $video_url, $matches ) ){
							$output = '<iframe src="http://player.vimeo.com/video/'.$matches[3].'" width="1100" height="619"  frameborder="0"></iframe>';
						}else{
							$output = __( 'Sorry that seems to be an invalid <strong>Vimeo</strong> URL. Please check it again. Make sure there is a string of numbers at the end.', 'amelie' );
						}
					}else{
						$output = __( 'Sorry that is an invalid YouTube or Vimeo URL.', 'amelie' );
					}
					echo $output;
					
				}else{
					echo stripslashes( htmlspecialchars_decode( $video_embed ) );
				}
					
			?>        
			</div>

				<script type="text/javascript">
				    jQuery(document).ready(function(){
				        //fitvideo
				       jQuery(".portfolio_single_video").fitVids();
				    });
				</script>
			  	   
				
			        <!-- if images exists ( slider )-->
			    <?php 
			}elseif( $image1 != '' || $image2 != '' || $image3 != '' || $image4 != '' || $image5 != ''   ){?> 
			    <div id="portfolio-gallery-container">
			    <?php if( $image1 != '' ){ ?>
			        <img src="<?php echo $image1; ?>"
			            alt="<?php echo get_the_title(  ); ?>"
			            title=""
			            data-desc=""
			            data-category="image"
			            data-fullsrc="http://arch/wp-content/themes/novo/bower_components/galereya/demo/upload/516495af618378.63011906.jpg" 
			             >
			    <?php } ?>
				<?php if( $image2 != '' ){ ?>
			        <img src="<?php echo $image2; ?>"
			            alt="<?php echo get_the_title(  ); ?>"
			            title=""
			            data-desc=""
			            data-category="image"
			            data-fullsrc="http://arch/wp-content/themes/novo/bower_components/galereya/demo/upload/516495af618378.63011906.jpg" 
			             >
			    <?php } ?>
			    <?php if( $image3 != '' ){ ?>
			        <img src="<?php echo $image3; ?>"
			            alt="<?php echo get_the_title(  ); ?>"
			            title=""
			            data-desc=""
			            data-category="image"
			            data-fullsrc="http://arch/wp-content/themes/novo/bower_components/galereya/demo/upload/516495af618378.63011906.jpg" 
			             >
			    <?php } ?>
			    <?php if( $image4 != '' ){ ?>
			        <img src="<?php echo $image4; ?>"
			            alt="<?php echo get_the_title(  ); ?>"
			            title=""
			            data-desc=""
			            data-category="image"
			            data-fullsrc="http://arch/wp-content/themes/novo/bower_components/galereya/demo/upload/516495af618378.63011906.jpg" 
			             >
			    <?php } ?>
			    <?php if( $image5 != '' ){ ?>
			        <img src="<?php echo $image5; ?>"
			            alt="<?php echo get_the_title(  ); ?>"
			            title=""
			            data-desc=""
			            data-category="image"
			            data-fullsrc="http://arch/wp-content/themes/novo/bower_components/galereya/demo/upload/516495af618378.63011906.jpg" 
			             >
			    <?php } ?>
				</div>
			    <?php 
			}else{?>      
				<!-- display fetaured image-->
				<div class="portfolio-items">
				<div class="wrap">
					<a href="<?php echo $thumbnail; ?>" title="<?php the_title(  ); ?>" rel="prettyPhoto[pp_gal]">
				    <span class="single_image_overlay">
				    <?php echo wp_get_attachment_image(  get_post_thumbnail_id(  $post->ID  ), 'Blog' );?>
				    </span>
					</a>
				</div>
				</div>
				<div style="display: none; " class="wrap">
					<?php echo zp_show_all_attached_image( $post->ID, 'pp_gal' , $thumbnail ); ?>
		 		</div>
			<?php
			}
		}//close else from ( !empty($attachments) )
		/*<header class="entry-header"><h1 class="entry-title" itemprop="headline"><?php echo the_title('','', false ) ?></h1></header>	*/
		?>       
		</div> <!-- end portfolio_single_feature -->
		<?php
		if( get_post_meta( $post->ID, 'lmseo_content_value', true ) == true ){?>
	        <hr class="small">
	        <div class="folio-entry" >
	        <div class="wrap">
			<?php the_content(  ); ?>
	        </div>
	        </div>
	        <?php 
		}
		$zp_project_link_value=get_post_meta( $post->ID, 'zp_project_link_value', true );
		$zp_project_label_value=get_post_meta( $post->ID, 'zp_project_label_value', true );
	    if($zp_project_link_value!='' && $zp_project_label_value!=''){?>
			<div class="meta-item">
			<div class="wrap">
	            <div class="projectlink"><a class="button" href="<?php echo $zp_project_link_value ?>"><?php echo $zp_project_label_value ?></a></div>
	        </div>
	        </div>            
	     	<?php 
	     }
		
		//do_action( 'genesis_entry_footer' );
	?>
	</article>
	<div class="before-related-folio">
	</div>
	<?php
		do_action( 'genesis_after_entry' );
		}//while end

	}//if end
	
	if (  genesis_get_option( 'zp_related_portfolio', ZP_SETTINGS_FIELD  ) ){?>
		<div class="folio-more">
		<div class="wrap">
		<?php  lmseo_related_portfolio(  ); ?>
		</div></div><!-- End columns. -->
	<?php 
		//do_action( 'genesis_before_footer' );
	}
}
//do_action( 'genesis_after_content' );
//do_action( 'genesis_footer' );
//do_action( 'genesis_after_footer' );

genesis(  );