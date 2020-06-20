<?php
/**
 * @package   Gantry 5 Theme
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2017 RocketTheme, LLC
 * @license   GNU/GPLv2 and later
 *
 * http://www.gnu.org/licenses/gpl-2.0.html
 */

defined('ABSPATH') or die;

use Timber\Timber;

/*
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * To generate specific templates for your pages you can use:
 * /mytheme/views/page-mypage.html.twig
 * (which will still route through this PHP file)
 * OR
 * /mytheme/page-mypage.php
 * (in which case you'll want to duplicate this file and save to the above path)
 */

$gantry = Gantry\Framework\Gantry::instance();
$theme  = $gantry['theme'];

// We need to render contents of <head> before plugin content gets added.
$context              = Timber::get_context();
$context['page_head'] = $theme->render('partials/page_head.html.twig', $context);

$args = array(
	    'post_type' => 'pool',
	    'posts_per_page' => -1,
	    'tax_query' => array(
	    	'relation' => 'AND',
	        array(
	            'taxonomy' => 'pool-model',
	            'field' => 'slug',
	            'terms' => array('thursday-pools')
	        )
	    ),
	    'orderby' => array(
	    	'date' => 'DESC'
));

$post            = Timber::get_posts( $args );
$context['pools'] = $post;

Timber::render('page-thursday-pools.html.twig', $context);

