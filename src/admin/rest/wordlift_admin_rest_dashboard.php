<?php
/**
 * Wordlift Dashboard Rest API.
 *
 * Defines the WordLift Dashboard Routes and GET Endpoints.
 *
 * @since 3.20.0
 * @package Wordlift
 * @subpackage Wordlift/admin/rest
 */

// Add the Rest Dashboard Controller
require_once( 'class_wordlift_admin_rest_dashboard.php' );

/**
 * Callback function for getting news. 
 */
function wl_get_dashboard_endpoint_news() {

	// Return news result.
	return rest_ensure_response( 
		Wordlift_Rest_Dashboard_Controller::get_instance()->getLatestNews() 
	);
}

/**
 * Callback function for getting backlink count and rank. 
 */
function wl_get_dashboard_endpoint_backlink_rank() {

	// Return backlink result.
	return rest_ensure_response( 
		''
	);
}

/**
 * Callback function for getting keyword count and rank. 
 */
function wl_get_dashboard_endpoint_keyword_rank() {

	// Return keyword rank result.
	return rest_ensure_response( 
		Wordlift_Rest_Dashboard_Controller::get_instance()->getKeywordRank() 
	);
}

/**
 * Callback function for getting top entities. 
 */
function wl_get_dashboard_endpoint_topentities() {

	// Return top entity result.
	return rest_ensure_response( 
		Wordlift_Rest_Dashboard_Controller::get_instance()->getTopEntities() 
	);
}

/**
 * Callback function for getting KPIs. 
 */
function wl_get_dashboard_endpoint_kpi() {

	// Return KPI result.
	return rest_ensure_response( 
		Wordlift_Rest_Dashboard_Controller::get_instance()->getKpi() 
	);
}

/**
 * Register dashboard routes with methods and callbacks.
 */
function wl_register_dashboard_routes() {

	// Register dashboard news.
	register_rest_route( 'wordlift/admin/v1', '/dashboard/news', array(
		// HTTP GET.
		'methods'  => WP_REST_Server::READABLE,
		// Dashboard feeds callback.
		'callback' => 'wl_get_dashboard_endpoint_news',
	) );
    
	// Register dashboard backlink-rank.
	register_rest_route( 'wordlift/admin/v1', '/dashboard/backlink-rank', array(
		// HTTP GET.
		'methods'  => WP_REST_Server::READABLE,
		// Dashboard backlink-rank callback.
		'callback' => 'wl_get_dashboard_endpoint_backlink_rank',
	) );

	// Register dashboard keyword-rank.
	register_rest_route( 'wordlift/admin/v1', '/dashboard/keyword-rank', array(
		// HTTP GET.
		'methods'  => WP_REST_Server::READABLE,
		// Dashboard keyword-rank callback.
		'callback' => 'wl_get_dashboard_endpoint_keyword_rank',
	) );

	// Register dashboard top-entities.
	register_rest_route( 'wordlift/admin/v1', '/dashboard/top-entities', array(
		// HTTP GET.
		'methods'  => WP_REST_Server::READABLE,
		// Dashboard top-entities callback.
		'callback' => 'wl_get_dashboard_endpoint_topentities',
	) );

	// Register dashboard kpi.
	register_rest_route( 'wordlift/admin/v1', '/dashboard/kpi', array(
		// HTTP GET.
		'methods'  => WP_REST_Server::READABLE,
		// Dashboard kpi callback.
		'callback' => 'wl_get_dashboard_endpoint_kpi',
	) );
}

// Call the WP-Rest action to enable endpoints defined above.
add_action( 'rest_api_init', 'wl_register_dashboard_routes' );
