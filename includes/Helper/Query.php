<?php
/**
 * Geocoding helper class.
 *
 * @package     posterno-geocoder
 * @copyright   Copyright (c) 2019, Pressmodo, LLC
 * @license     http://opensource.org/licenses/gpl_2.0.php GNU Public License
 */

namespace PNO\Geocoder\Helper;

use PNO\Geocoder\Vendor\yidas\googleMaps\Client as GMAP;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Helper library that queries the currently active map provider api to geocode addresses.
 */
class Query {

	/**
	 * Detect the currently active map provider in Posterno.
	 *
	 * @return string
	 */
	private static function get_active_provider() {

		$provider = pno_get_option( 'map_provider', 'googlemaps' );

		/**
		 * Filter: modifier for the currently active geocoding provider.
		 *
		 * @param string $provider the name of the provider, must be an option within the maps provider setting of Posterno.
		 * @return string.
		 */
		return apply_filters( 'pno_geocoder_active_provider', $provider );
	}

	/**
	 * Retrieve the credentials configuration for the currently active geocoding provider.
	 *
	 * @return array|string
	 */
	public static function get_provider_credentials() {

		$creds    = false;
		$provider = self::get_active_provider();

		switch ( $provider ) {
			case 'googlemaps':
				$key = pno_get_option( 'google_maps_api_key' );
				if ( $key ) {
					$creds = [
						'key' => $key,
					];
				}
				break;
		}

		/**
		 * Filter: allows to manually configure credentials for the currently active geocoding provider.
		 *
		 * @param array|string $creds the list of credentials.
		 * @param string $provider name of the currently active provider.
		 * @return array|string
		 */
		return apply_filters( 'pno_geocoder_provider_credentials', $creds, $provider );

	}

	/**
	 * Geocode coordinates and retrieve address information.
	 *
	 * @param string $lat coordinate.
	 * @param string $lng coordinate.
	 * @return mixed
	 */
	public static function geocode_coordinates( $lat, $lng ) {

		$geocoder_name = self::get_active_provider();
		$credentials   = self::get_provider_credentials();
		$response      = false;

		if ( ! $geocoder_name || ! $credentials ) {
			return;
		}

		switch ( $geocoder_name ) {
			case 'googlemaps':
				$provider = new GMAP( $credentials );
				$response = $provider->reverseGeocode( [ $lat, $lng ] );
				$response = Parser::parse( 'googlemaps', $response );
				break;
		}

		return $response;

	}

}
