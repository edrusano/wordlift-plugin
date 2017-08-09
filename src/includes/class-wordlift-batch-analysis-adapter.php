<?php
/**
 * Adapters: Batch Analysis Adapter.
 *
 * @since      3.14.2
 * @package    Wordlift
 * @subpackage Wordlift/includes
 */

/**
 * Define the {@link Wordlift_Batch_Analysis_Adapter} class.
 *
 * @since      3.14.2
 * @package    Wordlift
 * @subpackage Wordlift/includes
 */
class Wordlift_Batch_Analysis_Adapter {

	/**
	 * @var Wordlift_Batch_Analysis_Service
	 */
	private $batch_analysis_service;


	/**
	 * Wordlift_Batch_Analysis_Adapter constructor.
	 *
	 * @since 3.14.2
	 *
	 * @param \Wordlift_Batch_Analysis_Service $batch_analysis_service
	 */
	public function __construct( $batch_analysis_service ) {

		$this->batch_analysis_service = $batch_analysis_service;

	}

	public function submit_auto_selected_posts() {

		if ( ! isset( $_REQUEST['link'] ) ) {
			wp_die( 'The `link` parameter is required.' );
		}

		$count = $this->batch_analysis_service->submit_auto_selected_posts( $_REQUEST['link'] );

		// Clear any buffer.
		ob_clean();

		// Send the response.
		wp_send_json_success( array( 'count' => $count ) );

	}

}