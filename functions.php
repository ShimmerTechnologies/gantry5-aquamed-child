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

?>