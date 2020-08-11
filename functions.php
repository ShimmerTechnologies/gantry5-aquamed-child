<?php

add_filter( 'wpcf7_form_elements', 'sc_wpcf7_form_elements' );
 
function sc_wpcf7_form_elements( $form ) {
		$form = do_shortcode( $form );
		return $form;
}

add_action('init', 'aquamed_pool_types_init');

function aquamed_pool_types_init(){

	$labels = array(
		'name'  		  	 => _x('Pools', 'post type name', 'g5_aquapools'),
		'singular_name' 	 => _x('Pool', 'post type singular name', 'g5_aquapools'),
		'menu_name'			 => _x('Pools', 'admin menu', 'g5_aquapools'),
		'name_admin_bar'  	 => _x('Pool', 'add new on admin bar', 'g5_aquapools'),
		'add_new' 			 => _x('Add New', 'Add New Pool', 'g5_aquapools'),
		'add_new_item'   	 => _x('Add New Pool', 'g5_aquapools'),
		'new_item'		 	 => _x('New Pool', 'g5_aquapools'),
		'edit_item'		 	 => _x('Edit Pool', 'g5_aquapools'),
		'view_item'			 => _x('View Pool', 'g5_aquapools'),
		'all_items' 		 => _x('All Pools', 'g5_aquapools'),
		'search_items' 		 => _x('Search pools', 'g5_aquapools'),
		'not_found'			 => _x('No pools found', 'g5_aquapools'),
		'not_found_in_trash' => _x('No pools found in trash', 'g5_aquapools')
	);

	$args = array(
		'labels' 			=> $labels,
		'description'		=> __('Description.', 'g5_aquapools'),
		'public'			=> true,
		'public_queryable'	=> true,
		'show_ui'			=> true,
		'show_in_menu'		=> true,
		'query_var'			=> true,
		'rewrite'			=> array('slug' => 'pool'),
		'capability_type'	=> 'post',
		'has_archive'		=> false,
		'menu_position'		=> null,
		'show_in_rest'		=> true,
		'supports'			=> array('title', 'editor', 'author', 'thumbnail', 'excerpt')
	);

	register_post_type('pool', $args);

	$args = array(
			'hierarchical'			=> true,
			'labels'				=> 'Models',
			'singular_label' 		=> 'Model',
			'query_var'				=> true,
			'rewrite'				=> true,
			'slug'	 				=> 'pool-model',
	);
	register_taxonomy('pool-model', 'pool', $args );

	add_image_size('pool_image', 655, 525, true);

}

add_filter('manage_edit-pool_columns', "pool_manager_edit_columns");

add_action('after_setup_theme', 'aquamed_image_sizes');

function aquamed_image_sizes(){
	add_image_size('large-thumbnails', 370, 225, true);
}

function pool_manager_edit_columns($columns){
	$columns = array(
		"cb" 			=> "<input type=\"checkbox\" />",
		"title"			=> "Pool Name",
		"created"		=> 'Created Date',
		"cat"			=> "Model",
		);
	return $columns;
}

add_action("manage_pool_posts_custom_column", "pool_manager_custom_columns");

function pool_manager_custom_columns($column){
	global $post;
	$output = get_post_custom();

	switch($column)
	{
		case "created":
			$created = get_the_date();
			echo $created;
			break;
		case "cat":
			$type = get_the_term_list($post->ID, 'pool-model');
			echo $type;
			break;
	}
}

add_filter('manage_edit-pool_sortable_columns', 'pool_sortable_columns');

function pool_sortable_columns( $columns ){

	$columns['created'] = 'created';
	$columns['cat'] = 'cat';
	return $columns;
}

if( is_Admin() ){

	//meta callback functions for pools
	$dir = get_stylesheet_directory_uri();

	// https://wordpress.stackexchange.com/questions/1403/
	include( __DIR__  . '/includes/pool.php');

	function amp_pool_post_metaboxes(){
		add_meta_box('pool-specs', 'Pool Specifications', 'amp_pool_specs', 'pool', 'normal', 'high');
		add_meta_box('pool-videos', 'Pool Videos', 'amp_pool_videos', 'pool', 'normal', 'high');
		add_meta_box('pool-size', 'Pool Sizes', 'amp_pool_size', 'pool', 'normal', 'high');
	}
	add_action('admin_init', 'amp_pool_post_metaboxes');

}

function save_meta_box($post_id){

	global $post;
	$metaID = get_The_ID();

	if( get_post_type($metaID) == 'pool'){

		if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
				return;
		} else {

			if( isset($_POST['specs_title']) ){
				update_post_meta($post_id, 'specs_title', esc_attr($_POST['specs_title']));
			}
			if( isset($_POST['specs_text']) ){
				$data=htmlspecialchars($_POST['specs_text']);
				update_post_meta($post_id, 'specs_text', $data);
			}
			if( isset($_POST['video_title']) ){
				update_post_meta($post_id, 'video_title', esc_attr($_POST['video_title']));
			}
			if( isset($_POST['video_content']) ){
					$data=htmlspecialchars($_POST['video_content']);
					update_post_meta($post_id, 'video_content', $data);
			}
			if( isset($_POST['size_title']) ){
				update_post_meta($post_id, 'size_title', esc_attr($_POST['size_title']));
			}
			if( isset($_POST['size_length']) ){
				update_post_meta($post_id, 'size_length', esc_attr($_POST['size_length']));
			}
			if( isset($_POST['size_width']) ){
				update_post_meta($post_id, 'size_width', esc_attr($_POST['size_width']));
			}
			if( isset($_POST['size_shallow']) ){
				update_post_meta($post_id, 'size_shallow', esc_attr($_POST['size_shallow']));
			}
			if( isset($_POST['size_deep']) ){
				update_post_meta($post_id, 'size_deep', esc_attr($_POST['size_deep']));
			}
			// now we can actually save the data
			$allowed = array(
			        'a' => array( // on allow a tags
			            'href' => array() // and those anchors can only have href attribute
			        )
			);
			// If any value present in input field, then update the post meta
		    if(isset($_POST['add_size_length'])) {
		        // $post_id, $meta_key, $meta_value

		        update_post_meta( $post_id, 'add_size_length', $_POST['add_size_length'] );
		    }
		    if(isset($_POST['add_size_width'])) {
		        // $post_id, $meta_key, $meta_value
		    	
		        update_post_meta( $post_id, 'add_size_width', $_POST['add_size_width'] );
		    }
		     if(isset($_POST['add_size_shallow'])) {
		        // $post_id, $meta_key, $meta_value
		    	
		        update_post_meta( $post_id, 'add_size_shallow', $_POST['add_size_shallow'] );
		    }
		     if(isset($_POST['add_size_deep'])) {
		        // $post_id, $meta_key, $meta_value
		    	
		        update_post_meta( $post_id, 'add_size_deep', $_POST['add_size_deep'] );
		    }
			if ( isset($_POST['size_image_url']) ) {
				update_post_meta($post_id, "size_image_url", esc_attr($_POST["size_image_url"]));
			}
			if ( isset($_POST['size_image_id']) ) {
				update_post_meta($post_id, "size_image_id", esc_attr($_POST["size_image_id"]));
			}
		}

	}

}
add_action('save_post','save_meta_box');

add_filter( 'the_content', 'wpse_257854_remove_empty_p', PHP_INT_MAX );
add_filter( 'the_excerpt', 'wpse_257854_remove_empty_p', PHP_INT_MAX );
function wpse_257854_remove_empty_p( $content ) {
    return str_ireplace( '<p>&nbsp;</p>', '<br>', $content );
}

//Create extra fields called Altnative Text and Status
function my_extra_gallery_fields( $args, $attachment_id, $field ){
    $args['alt'] = array(
        'type' => 'text', 
        'label' => 'Altnative Text', 
        'name' => 'alt', 
        'value' => get_field($field . '_alt', $attachment_id)
    );
    $args['status'] = array(
        'type' => 'select', 
        'label' => 'Status', 
        'name' => 'status', 
        'value' => array(
            array(
                '1' => 'Active',
                 '2' => 'Inactive'
            ), 
            get_field($field . '_status', $attachment_id)
        )
    );
    return $args;
}
add_filter( 'acf_photo_gallery_image_fields', 'my_extra_gallery_fields', 10, 3 );



?>
