<?php
/**
 * REST-JSON WP Services: WordLift Dashboard Rest Json services.
 *
 * Handles the WordLift dashboard statistics.
 * Provides REST endpoints and collects data from 
 * WordLift WP, WordLift API, current WP Instance 
 *
 * @since 3.21.0
 * @package Wordlift
 * @subpackage Wordlift/admin/rest
 */
 
 // Add the Wordlift_Api_Service
//require_once( './../../includes/class-wordlift-api-service.php' );

 /**
 * Define the {@link Wordlift_Rest_Dashboard_Controller} class.
 *
 * @since 3.21.0
 */
class Wordlift_Rest_Dashboard_Controller {
	
	/**
	 * The WordLift WP URL path for dashboard news.
	 *
	 * @since 3.6.0
	 */
	const WORDLIFT_NEWS_FEEDS_URL = "https://wordlift.io/wp-json/wp/v2/posts?per_page=1";
	
	/**
	 * The Wordlift_Rest_Dashboard_Controller's singleton instance.
	 *
	 * @since  3.21.0
	 *
	 * @access private
	 * @var \Wordlift_Rest_Dashboard_Controller $instance Wordlift_Rest_Dashboard_Controller's singleton instance.
	 */
	private static $instance;
	
	/**
	 * The {@link Wordlift_Log_Service} instance.
	 *
	 * @since 3.16.0
	 *
	 * @var \Wordlift_Log_Service $log The {@link Wordlift_Log_Service} instance.
	 */
	private $log;
	
	/**
	 * A {@link Wordlift_Rating_Service} instance.
	 *
	 * @since  3.10.0
	 * @access private
	 * @var \Wordlift_Rating_Service $rating_service A {@link Wordlift_Rating_Service} instance.
	 */
	private $rating_service;

	/**
	 * The {@link Wordlift_Entity_Service} instance.
	 *
	 * @since  3.15.0
	 * @access private
	 * @var \Wordlift_Entity_Service $entity_service The {@link Wordlift_Entity_Service} instance.
	 */
	private $entity_service;

	/**
	 * Create a Wordlift_Rest_Dashboard_Controller's instance.
	 *
	 * @since 3.21.0
	 *
	 * @param \Wordlift_Rating_Service $rating_service A {@link Wordlift_Rating_Service} instance.
	 * @param \Wordlift_Entity_Service $entity_service The {@link Wordlift_Entity_Service} instance.
	 */
	public function __construct( $rating_service, $entity_service ) {

		$this->rating_service = $rating_service;
		$this->entity_service = $entity_service;

		$this->log = Wordlift_Log_Service::get_logger( get_class() );

		self::$instance = $this;

	}
	
	/**
	 * Get the {@link Wordlift_Rest_Dashboard_Controller} singleton instance.
	 *
	 * @since 3.21.0
	 *
	 * @return \Wordlift_Rest_Dashboard_Controller The {@link Wordlift_Rest_Dashboard_Controller} singleton instance.
	 */
	public static function get_instance() {

		return self::$instance;
	}

	/**
	 * Perform a `GET` request retrieving latest news.
	 *
	 * @since 3.21.0
	 *
	 *
	 * @return Response|WP_Error
	 */
	public function getLatestNews() {

		// Get the response value.
		return wp_remote_get( self::WORDLIFT_NEWS_FEEDS_URL );

	}
	
	/**
	 * Perform a `GET` request retrieving keyword rank.
	 *
	 * @since 3.21.0
	 *
	 *
	 * @return Response|WP_Error
	 */
	public function getKeywordRank() {

		// Get the response value.
		return Wordlift_Api_Service::get_instance()->get( 'entityrank' );

	}
	
	/**
	 * Perform a `GET` request retrieving top entities.
	 *
	 * @since 3.21.0
	 *
	 *
	 * @return Response|WP_Error
	 */
	public function getTopEntities() {

		// Get the response value.
		return '';

	}
	
	/**
	 * Perform a `GET` request retrieving KPIs.
	 *
	 * @since 3.21.0
	 *
	 *
	 * @return Response|WP_Error
	 */
	public function getKpi() {

		// Get the response value.
		return '';

	}
}