<?php
/**
 * Do not load this file directly.
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

function amp_pool_specs_title(){

		global $post;

		if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;

		$input = get_post_meta($post->ID);	

		if( isset($input["specs_title"]) ){
	        $specs_title = $input["specs_title"][0];
	    } 

	   ?>

	<div class="pool_specs_title">

	        <div><label>Pool Specifications Title:</label>
	        <input name="specs_title" type="text" value="<?php echo isset($specs_title) ? $specs_title : 'Features'; ?>" />
	    	</div>

	</div>

	<?php

	}

?>