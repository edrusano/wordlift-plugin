<?php
/**
 * Wordlift_Configuration_Service class.
 *
 * The {@link Wordlift_Configuration_Service} class provides helper functions to get configuration parameter values.
 *
 * @link       https://wordlift.io
 *
 * @package    Wordlift
 * @since      3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get WordLift's configuration settings stored in WordPress database.
 *
 * @since 3.6.0
 */
class Wordlift_Configuration_Service {

	/**
	 * The entity base path option name.
	 *
	 * @since 3.6.0
	 */
	const ENTITY_BASE_PATH_KEY = 'wl_entity_base_path';

	/**
	 * The skip wizard (admin installation wizard) option name.
	 *
	 * @since 3.9.0
	 */
	const SKIP_WIZARD = 'wl_skip_wizard';

	/**
	 * WordLift's key option name.
	 *
	 * @since 3.9.0
	 */
	const KEY = 'key';

	/**
	 * WordLift's configured language option name.
	 *
	 * @since 3.9.0
	 */
	const LANGUAGE = 'site_language';

	/**
	 * WordLift's configured country code.
	 *
	 * @since 3.18.0
	 */
	const COUNTRY_CODE = 'country_code';

	/**
	 * The publisher entity post ID option name.
	 *
	 * @since 3.9.0
	 */
	const PUBLISHER_ID = 'publisher_id';

	/**
	 * The dataset URI option name
	 *
	 * @since 3.10.0
	 */
	const DATASET_URI = 'redlink_dataset_uri';

	/**
	 * The link by default option name.
	 *
	 * @since 3.11.0
	 */
	const LINK_BY_DEFAULT = 'link_by_default';

	/**
	 * The user preferences about sharing data option.
	 *
	 * @since 3.19.0
	 */
	const SEND_DIAGNOSTIC = 'send_diagnostic';

	/**
	 * The package type configuration key.
	 *
	 * @since 3.20.0
	 */
	const PACKAGE_TYPE = 'package_type';

	/**
	 * The {@link Wordlift_Log_Service} instance.
	 *
	 * @since 3.16.0
	 *
	 * @var \Wordlift_Log_Service $log The {@link Wordlift_Log_Service} instance.
	 */
	private $log;

	/**
	 * The Wordlift_Configuration_Service's singleton instance.
	 *
	 * @since  3.6.0
	 *
	 * @access private
	 * @var \Wordlift_Configuration_Service $instance Wordlift_Configuration_Service's singleton instance.
	 */
	private static $instance;

	/**
	 * Create a Wordlift_Configuration_Service's instance.
	 *
	 * @since 3.6.0
	 */
	public function __construct() {

		$this->log = Wordlift_Log_Service::get_logger( get_class() );

		self::$instance = $this;

	}

	/**
	 * Get the singleton instance.
	 *
	 * @since 3.6.0
	 *
	 * @return \Wordlift_Configuration_Service
	 */
	public static function get_instance() {

		return self::$instance;
	}

	/**
	 * Get a configuration given the option name and a key. The option value is
	 * expected to be an array.
	 *
	 * @since 3.6.0
	 *
	 * @param string $option The option name.
	 * @param string $key A key in the option value array.
	 * @param string $default The default value in case the key is not found (by default an empty string).
	 *
	 * @return mixed The configuration value or the default value if not found.
	 */
	private function get( $option, $key, $default = '' ) {

		$options = get_option( $option, array() );

		return isset( $options[ $key ] ) ? $options[ $key ] : $default;
	}

	/**
	 * Set a configuration parameter.
	 *
	 * @since 3.9.0
	 *
	 * @param string $option Name of option to retrieve. Expected to not be SQL-escaped.
	 * @param string $key The value key.
	 * @param mixed  $value The value.
	 */
	private function set( $option, $key, $value ) {

		$values         = get_option( $option );
		$values         = isset( $values ) ? $values : array();
		$values[ $key ] = $value;
		update_option( $option, $values );

	}

	/**
	 * Get the entity base path, by default 'entity'.
	 *
	 * @since 3.6.0
	 *
	 * @return string The entity base path.
	 */
	public function get_entity_base_path() {

		return $this->get( 'wl_general_settings', self::ENTITY_BASE_PATH_KEY, 'entity' );
	}

	/**
	 * Get the entity base path.
	 *
	 * @since 3.9.0
	 *
	 * @param string $value The entity base path.
	 */
	public function set_entity_base_path( $value ) {

		$this->set( 'wl_general_settings', self::ENTITY_BASE_PATH_KEY, $value );

	}

	/**
	 * Whether the installation skip wizard should be skipped.
	 *
	 * @since 3.9.0
	 *
	 * @return bool True if it should be skipped otherwise false.
	 */
	public function is_skip_wizard() {

		return $this->get( 'wl_general_settings', self::SKIP_WIZARD, false );
	}

	/**
	 * Set the skip wizard parameter.
	 *
	 * @since 3.9.0
	 *
	 * @param bool $value True to skip the wizard. We expect a boolean value.
	 */
	public function set_skip_wizard( $value ) {

		$this->set( 'wl_general_settings', self::SKIP_WIZARD, true === $value );

	}

	/**
	 * Get WordLift's key.
	 *
	 * @since 3.9.0
	 *
	 * @return string WordLift's key or an empty string if not set.
	 */
	public function get_key() {

		return $this->get( 'wl_general_settings', self::KEY, '' );
	}

	/**
	 * Set WordLift's key.
	 *
	 * @since 3.9.0
	 *
	 * @param string $value WordLift's key.
	 */
	public function set_key( $value ) {

		$this->set( 'wl_general_settings', self::KEY, $value );
	}

	/**
	 * Get WordLift's configured language, by default 'en'.
	 *
	 * Note that WordLift's language is used when writing strings to the Linked Data dataset, not for the analysis.
	 *
	 * @since 3.9.0
	 *
	 * @return string WordLift's configured language code ('en' by default).
	 */
	public function get_language_code() {

		return $this->get( 'wl_general_settings', self::LANGUAGE, 'en' );
	}

	/**
	 * Set WordLift's language code, used when storing strings to the Linked Data dataset.
	 *
	 * @since 3.9.0
	 *
	 * @param string $value WordLift's language code.
	 */
	public function set_language_code( $value ) {

		$this->set( 'wl_general_settings', self::LANGUAGE, $value );

	}

	/**
	 * Set the user preferences about sharing diagnostic with us.
	 *
	 * @since 3.19.0
	 *
	 * @param string $value The user preferences(yes/no).
	 */
	public function set_diagnostic_preferences( $value ) {

		$this->set( 'wl_general_settings', self::SEND_DIAGNOSTIC, $value );

	}

	/**
	 * Get the user preferences about sharing diagnostic.
	 *
	 * @since 3.19.0
	 */
	public function get_diagnostic_preferences() {

		return $this->get( 'wl_general_settings', self::SEND_DIAGNOSTIC, 'no' );
	}

	/**
	 * Get WordLift's configured country code, by default 'us'.
	 *
	 * @since 3.18.0
	 *
	 * @return string WordLift's configured country code ('us' by default).
	 */
	public function get_country_code() {

		return $this->get( 'wl_general_settings', self::COUNTRY_CODE, 'us' );
	}

	/**
	 * Set WordLift's country code.
	 *
	 * @since 3.18.0
	 *
	 * @param string $value WordLift's country code.
	 */
	public function set_country_code( $value ) {

		$this->set( 'wl_general_settings', self::COUNTRY_CODE, $value );

	}

	/**
	 * Get the publisher entity post id.
	 *
	 * The publisher entity post id points to an entity post which contains the data for the publisher used in schema.org
	 * Article markup.
	 *
	 * @since 3.9.0
	 *
	 * @return int|NULL The publisher entity post id or NULL if not set.
	 */
	public function get_publisher_id() {

		return $this->get( 'wl_general_settings', self::PUBLISHER_ID, null );
	}

	/**
	 * Set the publisher entity post id.
	 *
	 * @since 3.9.0
	 *
	 * @param int $value The publisher entity post id.
	 */
	public function set_publisher_id( $value ) {

		$this->set( 'wl_general_settings', self::PUBLISHER_ID, $value );

	}

	/**
	 * Get the dataset URI.
	 *
	 * @since 3.10.0
	 *
	 * @return string The dataset URI or an empty string if not set.
	 */
	public function get_dataset_uri() {

		return $this->get( 'wl_advanced_settings', self::DATASET_URI, null );
	}

	/**
	 * Set the dataset URI.
	 *
	 * @since 3.10.0
	 *
	 * @param string $value The dataset URI.
	 */
	public function set_dataset_uri( $value ) {

		$this->set( 'wl_advanced_settings', self::DATASET_URI, $value );
	}

	/**
	 * Get the package type.
	 *
	 * @since 3.20.0
	 *
	 * @return string The package type or an empty string if not set.
	 */
	public function get_package_type() {

		return $this->get( 'wl_advanced_settings', self::PACKAGE_TYPE, null );
	}

	/**
	 * Set the package type.
	 *
	 * @since 3.20.0
	 *
	 * @param string $value The package type.
	 */
	public function set_package_type( $value ) {

		$this->set( 'wl_advanced_settings', self::PACKAGE_TYPE, $value );
	}

	/**
	 * Intercept the change of the WordLift key in order to set the dataset URI.
	 *
	 *
	 * @since 3.20.0 as of #761, we save settings every time a key is set, not only when the key changes, so to
	 *               store the configuration parameters such as country or language.
	 * @since 3.11.0
	 *
	 * @see https://github.com/insideout10/wordlift-plugin/issues/761
	 *
	 * @param array $old_value The old settings.
	 * @param array $new_value The new settings.
	 */
	public function update_key( $old_value, $new_value ) {

		// Check the old key value and the new one. We're going to ask for the dataset URI only if the key has changed.
		// $old_key = isset( $old_value['key'] ) ? $old_value['key'] : '';
		$new_key = isset( $new_value['key'] ) ? $new_value['key'] : '';

		// If the key hasn't changed, don't do anything.
		// WARN The 'update_option' hook is fired only if the new and old value are not equal.
		//		if ( $old_key === $new_key ) {
		//			return;
		//		}

		// If the key is empty, empty the dataset URI.
		if ( '' === $new_key ) {
			$this->set_dataset_uri( '' );
		}

		// make the request to the remote server.
		$this->get_remote_dataset_uri( $new_key );
	}

	/**
	 * Handle retrieving the dataset uri from the remote server.
	 *
	 * If a valid dataset uri is returned it is stored in the appropriate option,
	 * otherwise the option is set to empty string.
	 *
	 * @since 3.17.0 send the site URL and get the dataset URI.
	 * @since 3.12.0
	 *
	 * @param string $key The key to be used.
	 */
	public function get_remote_dataset_uri( $key ) {

		$this->log->trace( 'Getting the remote dataset URI and package type...' );

		/**
		 * Allow 3rd parties to change the site_url.
		 *
		 * @since 3.20.0
		 *
		 * @see https://github.com/insideout10/wordlift-plugin/issues/850
		 *
		 * @param string $site_url The site url.
		 */
		$site_url = apply_filters( 'wl_production_site_url', site_url() );

		// Build the URL.
		$url = $this->get_accounts()
		       . '?key=' . rawurlencode( $key )
		       . '&url=' . rawurlencode( $site_url )
		       . '&country=' . $this->get_country_code()
		       . '&language=' . $this->get_language_code();

		$args     = wp_parse_args( unserialize( WL_REDLINK_API_HTTP_OPTIONS ), array(
			'method' => 'PUT',
		) );
		$response = wp_remote_request( $url, $args );

		// The response is an error.
		if ( is_wp_error( $response ) ) {
			$this->log->error( 'An error occurred setting the dataset URI: ' . $response->get_error_message() );

			$this->set_dataset_uri( '' );
			$this->set_package_type( null );

			return;
		}

		// The response is not OK.
		if ( 200 !== (int) $response['response']['code'] ) {
			$this->log->error( "Unexpected status code when opening URL $url: " . $response['response']['code'] );

			$this->set_dataset_uri( '' );
			$this->set_package_type( null );

			return;
		}

		/*
		 * We also store the package type.
		 *
		 * @since 3.20.0
		 */
		$json         = json_decode( $response['body'] );
		$dataset_uri  = $json->datasetURI;
		$package_type = isset( $json->packageType ) ? $json->packageType : null;

		$this->log->info( "Updating [ dataset uri :: $dataset_uri ][ package type :: $package_type ]..." );

		$this->set_dataset_uri( $dataset_uri );
		$this->set_package_type( $package_type );

	}

	/**
	 * Handle the edge case where a user submits the same key again
	 * when he does not have the dataset uri to regain it.
	 *
	 * This can not be handled in the normal option update hook because
	 * it is not being triggered when the save value equals to the one already
	 * in the DB.
	 *
	 * @since 3.12.0
	 *
	 * @param mixed $value The new, unserialized option value.
	 * @param mixed $old_value The old option value.
	 *
	 * @return mixed The same value in the $value parameter
	 */
	function maybe_update_dataset_uri( $value, $old_value ) {

		// Check the old key value and the new one. Here we're only handling the
		// case where the key hasn't changed and the dataset URI isn't set. The
		// other case, i.e. a new key is inserted, is handled at `update_key`.
		$old_key = isset( $old_value['key'] ) ? $old_value['key'] : '';
		$new_key = isset( $value['key'] ) ? $value['key'] : '';

		$dataset_uri = $this->get_dataset_uri();

		if ( ! empty( $new_key ) && $new_key === $old_key && empty( $dataset_uri ) ) {

			// make the request to the remote server to try to get the dataset uri.
			$this->get_remote_dataset_uri( $new_key );
		}

		return $value;
	}

	/**
	 * Get the API URI to retrieve the dataset URI using the WordLift Key.
	 *
	 * @since 3.11.0
	 *
	 * @param string $key The WordLift key to use.
	 *
	 * @return string The API URI.
	 */
	public function get_accounts_by_key_dataset_uri( $key ) {

		return WL_CONFIG_WORDLIFT_API_URL_DEFAULT_VALUE . "accounts/key=$key/dataset_uri";
	}

	/**
	 * Get the `accounts` end point.
	 *
	 * @since 3.16.0
	 *
	 * @return string The `accounts` end point.
	 */
	public function get_accounts() {

		return WL_CONFIG_WORDLIFT_API_URL_DEFAULT_VALUE . 'accounts';
	}

	/**
	 * Get the `link by default` option.
	 *
	 * @since 3.13.0
	 *
	 * @return bool True if entities must be linked by default otherwise false.
	 */
	public function is_link_by_default() {

		return 'yes' === $this->get( 'wl_general_settings', self::LINK_BY_DEFAULT, 'yes' );
	}

	/**
	 * Set the `link by default` option.
	 *
	 * @since 3.13.0
	 *
	 * @param bool $value True to enabling linking by default, otherwise false.
	 */
	public function set_link_by_default( $value ) {

		$this->set( 'wl_general_settings', self::LINK_BY_DEFAULT, true === $value ? 'yes' : 'no' );
	}

	/**
	 * Get the URL to perform batch analyses.
	 *
	 * @since 3.14.0
	 *
	 * @return string The URL to call to perform the batch analyzes.
	 */
	public function get_batch_analysis_url() {

		return WL_CONFIG_WORDLIFT_API_URL_DEFAULT_VALUE . 'batch-analyses';

	}

	/**
	 * Get the URL to perform autocomplete request.
	 *
	 * @since 3.15.0
	 *
	 * @return string The URL to call to perform the batch analyzes.
	 */
	public function get_autocomplete_url() {

		return WL_CONFIG_WORDLIFT_API_URL_DEFAULT_VALUE . 'autocomplete';

	}

	/**
	 * Get the URL to perform feedback deactivation request.
	 *
	 * @since 3.19.0
	 *
	 * @return string The URL to call to perform the feedback deactivation request.
	 */
	public function get_deactivation_feedback_url() {

		return WL_CONFIG_WORDLIFT_API_URL_DEFAULT_VALUE . 'feedbacks';

	}

	/**
	 * Get the base API URL.
	 *
	 * @since 3.20.0
	 *
	 * @return string The base API URL.
	 */
	public function get_api_url() {

		return WL_CONFIG_WORDLIFT_API_URL_DEFAULT_VALUE;
	}

}
