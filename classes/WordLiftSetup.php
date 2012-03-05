<?php

class WordLiftSetup {

	private static $logger;

	/*
	 * sets-up the WordLift plug-in pre-requisites such as:
	 *  - the Entity Post-Type.
	 *  - the taxonomy. 
	 */
	function setup() {
		self::$logger = Logger::getLogger(__CLASS__);

		self::create_post_type();
		self::create_taxonomies();
	}

	/* 
	 * enqueus the JavaScript and style-sheets for WordPress inclusion.
	 */
	function admin_enqueue_scripts() {

		wp_enqueue_style('jquery.isotope.css',
			plugins_url('/css/jquery.isotope.css', WORDLIFT_20_ROOT_PATH));

		wp_enqueue_script('jquery.isotope',
			plugins_url('/js/jquery.isotope.min.js', WORDLIFT_20_ROOT_PATH),
			array('jquery'),
			false,
			true);

		wp_enqueue_script('underscore',
			plugins_url('/js/underscore-min.js', WORDLIFT_20_ROOT_PATH),
			array(),
			false,
			true);

		wp_enqueue_script('backbone',
			plugins_url('/js/backbone-min.js', WORDLIFT_20_ROOT_PATH),
			array('underscore'),
			false,
			true);

		wp_enqueue_script('wordlift',
			plugins_url('/js/wordlift.js', WORDLIFT_20_ROOT_PATH),
			array('backbone'),
			false,
			true);

		echo '<script type="text/javascript"> var WORDLIFT_20_URL = \''.plugins_url('/', WORDLIFT_20_ROOT_PATH).'\'; var WORDLIFT_20_POST_ID = \''.get_the_ID().'\';</script>';

	}

	function create_post_type() {

		self::$logger->debug('Registering post-type ['.POST_CUSTOM_TYPE_ENTITY.'].');

		$return = register_post_type( POST_CUSTOM_TYPE_ENTITY,
			array(
				'labels' => array(
					'name' => __( 'Entities' ),
					'singular_name' => __( 'Entity' )),
				'description' => 'The entities found in this blog.',
				'public' => true,
				'has_archive' => true,
				'menu_position' => POST_CUSTOM_TYPE_ENTITY_MENU_POSITION,
				'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
				'register_meta_box_cb' => 'register_meta_box_cb'
			)
		);
	}

	function create_taxonomies(){
		self::$logger->debug('Registering taxonomy ['.WORDLIFT_20_TAXONOMY_NAME.'].');

		register_taxonomy(WORDLIFT_20_TAXONOMY_NAME, 'post', array(
				'labels' => array(
						'name' 			=> _x('Entities', 'Taxonomy general name (plural)'),
						'singular_name' => _x('Entity', ''),
						'search_items'  => _x('Search Entities', ''),
						'popular_items' => _x('Popular Entities', ''),
						'all_items' 	=> _x('All Entities', ''),
						'parent_item'   => _x('Parent', ''),
						'parent_item_colon' => _x('Parent:', ''),
						'edit_item'		=> _x('Edit Entity', ''),
						'update_item'	=> _x('Update Entity', ''),
						'add_new_item'  => _x('Add New Entity', ''),
						'new_item_name' => _x('New Entity Name', ''),
						'separate_items_with_commas' => _x('Separate Entities with Commas', ''),
						'add_or_remove_items' => _x('Add or Remove Entities', ''),
						'choose_from_most_used' => _x('Choose from the most used Entities', ''),
						'menu_name'		=> _x('Entities Taxonomy', '')
					),
				'public' 			=> true,
				'show_in_nav_menus' => true,
				'hierarchical'		=> true
			));

		// register the basic slugs
		wp_insert_term( WORDLIFT_20_TAXONOMY_CREATIVE_WORK, WORDLIFT_20_TAXONOMY_NAME, array(
				'description' 	=> _x('Creative Works', ''),
				'slug'			=> WORDLIFT_20_TAXONOMY_CREATIVE_WORK_SLUG
			) );
		wp_insert_term( WORDLIFT_20_TAXONOMY_EVENT, WORDLIFT_20_TAXONOMY_NAME, array(
				'description' 	=> _x('Events', ''),
				'slug'			=> WORDLIFT_20_TAXONOMY_EVENT_SLUG
			) );
		wp_insert_term( WORDLIFT_20_TAXONOMY_ORGANIZATION, WORDLIFT_20_TAXONOMY_NAME, array(
				'description' 	=> _x('Organizations', ''),
				'slug'			=> WORDLIFT_20_TAXONOMY_ORGANIZATION_SLUG
			) );
		wp_insert_term( WORDLIFT_20_TAXONOMY_PERSON, WORDLIFT_20_TAXONOMY_NAME, array(
				'description' 	=> _x('People', ''),
				'slug'			=> WORDLIFT_20_TAXONOMY_PERSON_SLUG
			) );
		wp_insert_term( WORDLIFT_20_TAXONOMY_PLACE, WORDLIFT_20_TAXONOMY_NAME, array(
				'description' 	=> _x('Places', ''),
				'slug'			=> WORDLIFT_20_TAXONOMY_PLACE_SLUG
			) );
		wp_insert_term( WORDLIFT_20_TAXONOMY_PRODUCT, WORDLIFT_20_TAXONOMY_NAME, array(
				'description' 	=> _x('Products', ''),
				'slug'			=> WORDLIFT_20_TAXONOMY_PRODUCT_SLUG
			) );
		wp_insert_term( WORDLIFT_20_TAXONOMY_OTHER, WORDLIFT_20_TAXONOMY_NAME, array(
				'description' 	=> _x('Other', ''),
				'slug'			=> WORDLIFT_20_TAXONOMY_OTHER_SLUG
			) );

	}
}

?>
