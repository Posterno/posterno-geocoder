<?php
/**
 * Geocoding helper class.
 *
 * @package     posterno-geocoder
 * @copyright   Copyright (c) 2019, Pressmodo, LLC
 * @license     http://opensource.org/licenses/gpl_2.0.php GNU Public License
 */

namespace PNO\Geocoder\Helper;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Helper library that queries the currently active map provider api to geocode addresses.
 */
class Query {

	public $active_provider = false;

	public function __construct() {

		$this->active_provider = $this->get_active_provider();

	}

	private function get_active_provider() {
		return pno_get_option( 'map_provider', 'googlemaps' );
	}

	private function get_active_provider_classname() {

	}

	public function geocode_coordinates( $lat, $lng ) {

	}

}
