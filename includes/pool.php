<?php
/**
 * Do not load this file directly.
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

function amp_pool_specs(){

		global $post;

		$input = get_post_meta($post->ID);	

		if( isset($input["specs_title"]) ){
	        $specs_title = $input["specs_title"][0];
	    } 
	    if( isset($input["specs_text"]) ){
	        $specs_text = $input["specs_text"][0];
	    } 

	   ?>

	<div class="pool_specs">

	        <div><label>Title:</label>
	        <input name="specs_title" type="text" value="<?php echo isset($specs_title) ? $specs_title : 'Features'; ?>" />
	    	</div>
	    	<br>
	    	<div>
	    	<?php	

	    		$text = get_post_meta($post->ID, 'specs_text', true);
				wp_editor( htmlspecialchars_decode($text), 'pool_specs_id', $settings=array('textarea_name'=>'specs_text'));
			?>
			</div>

	</div>

	<?php

	}

function amp_pool_videos(){

	global $post;

	$input = get_post_meta($post->ID);	

	if( isset($input["video_title"]) ){
	    $video_title = $input["video_title"][0];
	} 
	if( isset($input["video_content"]) ){
	    $video_content = $input["video_content"][0];
	} 


?>
		<div class="video_content">

	        <div>
		        <label>Title:</label>
		        <input name="video_title" type="text" value="<?php echo isset($video_title) ? $video_title : ''; ?>" />
		    </div>
	    	<br>	    
	    	<div>
<?php
			$content = get_post_meta($post->ID, 'video_content', true);
			wp_editor( htmlspecialchars_decode($content), 'video_content_id', $settings=array('textarea_name'=> 'video_content'));
?>
			</div>

		</div>

<?php
}

function amp_pool_size(){

	global $post;
	wp_enqueue_media();
	wp_register_script('photo_upload.js', get_stylesheet_directory_uri() . '/includes/js/photo_upload.js', true);
	wp_enqueue_script( 'photo_upload.js' );
	wp_register_script('dynamic_sizes.js', get_stylesheet_directory_uri() . '/includes/js/dynamic_sizes.js', true);
	wp_enqueue_script( 'dynamic_sizes.js' );

	$input = get_post_meta($post->ID);	

	if( isset($input["size_title"]) ){
	    $size_title = $input["size_title"][0];
	} 
	if( isset($input["size_length"]) ){
	    $size_length = $input["size_length"][0];
	} 
	if( isset($input["size_width"]) ){
	    $size_width = $input["size_width"][0];
	} 
	if( isset($input["size_shallow"]) ){
	    $size_shallow = $input["size_shallow"][0];
	}  
	if( isset($input["size_deep"]) ){
	    $size_deep = $input["size_deep"][0];
	} 
	if( isset($input["size_image_url"]) ){
	    $size_image_url = $input["size_image_url"][0];
	} 

	// Get WordPress' media upload URL
	$upload_link = esc_url( get_upload_iframe_src( 'image', $post->ID ) );

	// See if there's a media id already saved as post meta
	$your_img_id = get_post_meta( $post->ID, '_your_img_id', true );

	// Get the image src
	$your_img_src = wp_get_attachment_image_src( $your_img_id, 'full' );

	// For convenience, see if the array is valid
	$you_have_img = is_array( $your_img_src );

	$size_image_url = get_post_meta($post->ID, 'size_image_url', true);
	$size_image_id = get_post_meta($post->ID, 'size_image_id', true);


?>
		<div class="pool_sizes">

	        <div>
		        <label>Title:</label>
		        <input name="size_title" type="text" value="<?php echo isset($size_title) ? $size_title : 'Sizes'; ?>" />
		    </div>
	    	<br>	    
	    	<div>

				<label>Image:</label>						
				<!-- Your image container, which can be manipulated with js -->
				<div class="custom-img-container">
				    <?php if ( $you_have_img ) : ?>
				        <img src="<?php echo $your_img_src[0] ?>" alt="" style="max-width:100%;" />
				    <?php else: ?>
				    	<img src="<?php echo $size_image_url ?>" alt="" style="max-width:100%;" class="remove_image" />
				    <?php endif; ?>
				</div>

				<!-- Your add & remove image links -->
				<p class="hide-if-no-js">
				    <a class="upload-custom-img <?php if ( $you_have_img  ) { echo 'hidden'; } ?>" 
				       href="<?php echo $upload_link ?>">
				        <?php _e('Set Image') ?>
				    </a>
				    <a class="delete-custom-img <?php if ( ! $you_have_img  ) { echo 'hidden'; } ?>" 
				      href="#">
				        <?php _e('Remove this image') ?>
				    </a>
				</p>

				<!-- A hidden input to set and post the chosen image id -->
				<input class="size_image_url" name="size_image_url" type="hidden" value="<?php echo !empty($size_image_url) && empty($your_img_src[0]) ? $size_image_url : $your_img_src[0]; ?>" />
				<input class="size_image_id" name="size_image_id" type="hidden" value="<?php echo !empty($size_image_id) && empty($your_img_id) ? $size_image_id : esc_attr( $your_img_id ); ?>" />
	
			</div>
			<br>
				
			<div>
					<a class="add_field_button button-secondary">Add Size</a>
					<br>
					<div>
						<label>Length</label>
						<input type="text" name="size_length" value="<?php echo isset($size_length) ? $size_length : ''; ?>" >
					</div>
					<div>
						<label>Width</label>
						<input type="text" name="size_width" value="<?php echo isset($size_width) ? $size_width : ''; ?>">
					</div>
					<div>
						<label>Shallow Depth</label>
						<input type="text" name="size_shallow" value="<?php echo isset($size_shallow) ? $size_shallow : ''; ?>">
					</div>					
					<div>
						<label>Deep Depth</label>
						<input type="text" name="size_deep" value="<?php echo isset($size_deep) ? $size_deep : ''; ?>" >
					</div> 
					<br>
					<div class="input_sizes">
					<?php

					    
					    $add_size_length = get_post_meta($post->ID, 'add_size_length', true);
					    if ( is_array( $add_size_length ) ) { $add_size_length = array_filter($add_size_length); }

					    $add_size_width = get_post_meta($post->ID, 'add_size_width', true);
					    if ( is_array( $add_size_width ) ) { $add_size_width = array_filter($add_size_width); }				   
					    
					    $add_size_shallow = get_post_meta($post->ID, 'add_size_shallow', true);
					    if ( is_array( $add_size_shallow ) ) { $add_size_shallow = array_filter($add_size_shallow); }

					    $add_size_deep = get_post_meta($post->ID, 'add_size_deep', true);
					    if ( is_array( $add_size_deep ) ) { $add_size_deep = array_filter($add_size_deep); }

					    if( isset( $add_size_length ) && !empty( $add_size_length ) ) {
					    	
					    	$i = 0;
        					$output = '';

					        foreach($add_size_length as $length){

					        	$output = '<div class="added_sizes_'. $i .'">';
					        	if(isset($add_size_length)){
					        		$output .= '<div><label>Length</label><input type="text" name="add_size_length[]" value="' . htmlspecialchars( $length ) . '"></div>';
					        	}					            

					            if ( !empty( $add_size_width[$i] ) ) {
							    	$output .= '<div><label>Width</label><input type="text" name="add_size_width[]" value="' . htmlspecialchars( $add_size_width[$i] ) . '"></div>';
								} else {
						    		$output .= '<div><label>Width</label><input type="text" name="add_size_width[]"></div>';
						    	}
						
						    	if ( !empty( $add_size_shallow[$i] ) ) {
							        $output .= '<div><label>Shallow Depth</label><input type="text" name="add_size_shallow[]" value="' . htmlspecialchars( $add_size_shallow[$i] ) . '"></div>';
							    } else {
						    		$output .= '<div><label>Shallow Depth</label><input type="text" name="add_size_shallow[]"></div>';
						    	}
							    if ( !empty( $add_size_deep[$i] ) ) {
							        $output .= '<div><label>Deep Depth</label><input type="text" name="add_size_deep[]" value="' . htmlspecialchars( $add_size_deep[$i] ) . '"></div>';
						    	} else {
						    		$output  .= '<div><label>Deep Depth</label><input type="text" name="add_size_deep[]"></div>';
						    	}

						        $output .= '</div><br>';

						       	echo $output;
						        $i++;

					        }
					    } 
    
				    ?>
								
					</div> 		    
			</div>


		</div>

<?php
}

?>

